<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Facility;
use App\Models\User;
use App\Services\GmailService;
use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;

class ReservationController extends Controller
{
    private $gmailService;
    private $calendarService;

    public function __construct(GmailService $gmailService, GoogleCalendarService $calendarService)
    {
        $this->gmailService = $gmailService;
        $this->calendarService = $calendarService;
    }

    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $reservations = Reservation::with(['facility', 'user'])
                ->orderBy('requested_date', 'desc')
                ->get();

            foreach ($reservations as $res) {
                if (str_contains($res->description, 'Clinic Sync:')) {
                    try {
                        $patientName = trim(str_ireplace('CLINIC:', '', $res->guest_name));
                        
                        // We fetch the 'time' column directly as a string to avoid timezone shifts
                        $clinicAppointment = DB::connection('clinic')->table('appointments')
                            ->where('user_id', $res->user_id)
                            ->whereDate('date', $res->requested_date)
                            ->where('patient_name', $patientName)
                            ->select('time')
                            ->first();

                        if ($clinicAppointment) {
                            // Store the raw string (e.g., "15:23:00")
                            $res->actual_appointment_time = $clinicAppointment->time;
                        } else {
                            $res->actual_appointment_time = null;
                        }

                    } catch (Exception $e) {
                        $res->actual_appointment_time = null;
                        Log::warning("Index Clinic Time Fetch Error: " . $e->getMessage());
                    }
                }
            }
        } else {
            $reservations = $user->reservations()->with('facility')->get();
        }
        
        return view('reservations.index', compact('reservations'));
    }

    public function create(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('toast_error', 'Please login to make a reservation.');
        }
        
        $facilityId = $request->query('facility');
        if ($facilityId) {
            $facility = Facility::findOrFail($facilityId);
            if ($facility->reservations()->where('status', 'approved')->exists()) {
                return redirect()->route('user.dashboard')->with('toast_error', 'Sorry, this facility is already reserved.');
            }
            return view('reservations.user-create', compact('facility'));
        }

        $facilities = Facility::where('status', 'active')->get();
        return view('reservations.user-create', compact('facilities'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) return redirect()->route('login')->with('toast_error', 'Please login.');
        
        $facility = Facility::findOrFail($request->facility_id);
        if ($facility->reservations()->where('status', 'approved')->exists()) {
            return back()->with('toast_error', 'This facility is already reserved.');
        }
        
        $validated = $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'estimated_participants' => 'required|integer|min:1',
            'description' => 'required|string',
            'requested_date' => 'required|date|after:today',
        ]);

        try {
            $user = auth()->user();
            $validated['user_id'] = $user->id;
            $validated['guest_name'] = $user->name;
            $validated['guest_contact'] = $user->gmail_address ?? $user->email;
            $validated['status'] = 'pending';

            $reservation = Reservation::create($validated);
            
            if ($reservation->guest_contact) {
                $this->gmailService->sendReservationSubmissionEmail($reservation);
            }
            
            $adminEmails = User::where('role', 'admin')->pluck('gmail_address')->filter()->toArray();
            foreach ($adminEmails as $adminEmail) {
                $this->gmailService->sendAdminSubmissionNotification($reservation, $adminEmail);
            }

            return redirect()->route('user.dashboard')->with('toast_success', 'Reservation submitted!');
        } catch (Exception $e) {
            Log::error("Reservation Error: " . $e->getMessage());
            return redirect()->route('user.dashboard')->with('toast_error', 'Submission error.');
        }
    }

    public function approveReservation(Request $request, Reservation $reservation)
    {
        if (!auth()->user()->isAdmin()) abort(403);
        $validated = $request->validate(['available_date' => 'required|date']);

        try {
            $reservation->update([
                'status' => 'approved',
                'available_date' => $validated['available_date'], 
            ]);
            
            if (str_contains($reservation->description, 'Clinic Sync:')) {
                $patientName = trim(str_ireplace('CLINIC:', '', $reservation->guest_name));
                
                DB::connection('clinic')->table('appointments')
                    ->where('user_id', $reservation->user_id)
                    ->whereDate('date', $reservation->requested_date)
                    ->where('patient_name', $patientName)
                    ->update(['status' => 'Approved', 'updated_at' => now()]);
            }

            $this->calendarService->createReservationEvent($reservation);
            $this->gmailService->sendReservationApprovedEmail($reservation);
            
            return redirect()->back()->with('toast_success', 'Approved and synced with Clinic!');
        } catch (Exception $e) {
            Log::error("Approval Sync Error: " . $e->getMessage());
            return redirect()->back()->with('toast_error', 'Sync failed: ' . $e->getMessage());
        }
    }

    public function rejectReservation(Reservation $reservation)
    {
        if (!auth()->user()->isAdmin()) abort(403);

        try {
            $reservation->update(['status' => 'rejected']);

            if (str_contains($reservation->description, 'Clinic Sync:')) {
                $patientName = trim(str_ireplace('CLINIC:', '', $reservation->guest_name));

                DB::connection('clinic')->table('appointments')
                    ->where('user_id', $reservation->user_id)
                    ->whereDate('date', $reservation->requested_date)
                    ->where('patient_name', $patientName)
                    ->update(['status' => 'Rejected', 'updated_at' => now()]);
            }

            $this->gmailService->sendReservationRejectedEmail($reservation);
            
            return redirect()->back()->with('toast_error', 'Reservation rejected and Clinic notified.');
        } catch (Exception $e) {
            Log::error("Rejection Sync Error: " . $e->getMessage());
            return redirect()->back()->with('toast_error', 'Sync failed: ' . $e->getMessage());
        }
    }

    public function show(Reservation $reservation)
    {
        if (auth()->id() !== $reservation->user_id && !auth()->user()->isAdmin()) abort(403);

        $reservation->load('facility');
        $clinicData = null;

        if (str_contains($reservation->description, 'Clinic Sync:')) {
            try {
                $patientName = trim(str_ireplace('CLINIC:', '', $reservation->guest_name));
                
                $clinicData = DB::connection('clinic')->table('appointments')
                    ->where('user_id', $reservation->user_id)
                    ->whereDate('date', $reservation->requested_date)
                    ->where('patient_name', $patientName)
                    ->first();
            } catch (Exception $e) {
                Log::warning("Clinic details error: " . $e->getMessage());
            }
        }

        if (request()->ajax()) {
            return response()->json(['reservation' => $reservation, 'clinic_details' => $clinicData]);
        }

        return view('reservations.show', compact('reservation', 'clinicData'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        if (auth()->id() !== $reservation->user_id && !auth()->user()->isAdmin()) abort(403);
        $reservation->update($request->validate([
            'status' => 'required|in:pending,approved,rejected,cancelled',
            'notes' => 'nullable|string',
        ]));
        return redirect()->route('user.dashboard')->with('toast_success', 'Updated!');
    }

    public function destroy(Reservation $reservation)
    {
        if (auth()->id() !== $reservation->user_id) abort(403);
        if ($reservation->status !== 'pending') return redirect()->route('user.dashboard')->with('toast_error', 'Cannot cancel.');
        $reservation->delete();
        return redirect()->route('user.dashboard')->with('toast_success', 'Cancelled.');
    }
}