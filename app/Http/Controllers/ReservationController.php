<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Facility;
use App\Models\User;
use App\Services\GmailService;
use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $reservations = auth()->user()->reservations()->with('facility')->get();
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
            $hasApprovedReservation = $facility->reservations()->where('status', 'approved')->exists();
            
            if ($hasApprovedReservation) {
                return redirect()->route('user.dashboard')->with('toast_error', 'Sorry, this facility is already reserved.');
            }

            return view('reservations.user-create', compact('facility'));
        }

        $facilities = Facility::where('status', 'active')->get();
        return view('reservations.user-create', compact('facilities'));
    }

    /**
     * Store reservation with Error Handling for Gmail Service
     */
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('toast_error', 'Please login.');
        }
        
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
            $validated['requested_date'] = $request->requested_date; 

            // Database Operation
            $reservation = Reservation::create($validated);
            
            // API Operations (Wrapped in the same try-catch)
            if ($reservation->guest_contact) {
                $this->gmailService->sendReservationSubmissionEmail($reservation);
            }
            
            $adminEmails = User::where('role', 'admin')->pluck('gmail_address')->filter()->toArray();
            foreach ($adminEmails as $adminEmail) {
                $this->gmailService->sendAdminSubmissionNotification($reservation, $adminEmail);
            }

            return redirect()->route('user.dashboard')->with('toast_success', 'Reservation submitted and emails sent!');

        } catch (Exception $e) {
            Log::error("Reservation Storage/Email Error: " . $e->getMessage());
            
            // If the code reaches here, it means the DB might have failed or the Email Service crashed.
            return redirect()->route('user.dashboard')->with('toast_error', 'System encountered an error during submission.');
        }
    }

    /**
     * Approve reservation with Error Handling for Google Calendar API
     */
    public function approveReservation(Request $request, Reservation $reservation)
    {
        if (!auth()->user()->isAdmin()) { abort(403); }

        $validated = $request->validate([
            'available_date' => 'required|date',
        ]);

        try {
            // 1. Update local DB first
            $reservation->update([
                'status' => 'approved',
                'available_date' => $validated['available_date'], 
            ]);
            
            // 2. Attempt External API Syncs
            $eventCreated = $this->calendarService->createReservationEvent($reservation);
            $this->gmailService->sendReservationApprovedEmail($reservation);
            
            if ($eventCreated) {
                return redirect()->back()->with('toast_success', 'Reservation approved and added to Google Calendar!');
            }

            return redirect()->back()->with('toast_error', 'Approved, but Calendar sync failed.');

        } catch (Exception $e) {
            Log::error("Google API Sync Error: " . $e->getMessage());
            
            // Graceful failure: DB is updated, but notify user about the API sync issue
            return redirect()->back()->with('toast_error', 'Approved locally, but could not sync with Google services.');
        }
    }

    public function rejectReservation(Reservation $reservation)
    {
        if (!auth()->user()->isAdmin()) { abort(403); }

        try {
            $reservation->update(['status' => 'rejected']);
            $this->gmailService->sendReservationRejectedEmail($reservation);
            
            return redirect()->back()->with('toast_error', 'Reservation rejected and user notified.');
        } catch (Exception $e) {
            Log::error("Rejection Email Error: " . $e->getMessage());
            return redirect()->back()->with('toast_error', 'Rejected in system, but email failed to send.');
        }
    }

    public function show(Reservation $reservation)
    {
        $reservation->load('facility');
        if (auth()->id() !== $reservation->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }
        return view('reservations.show', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        if (auth()->id() !== $reservation->user_id && !auth()->user()->isAdmin()) { abort(403); }
        
        $reservation->update($request->validate([
            'status' => 'required|in:pending,approved,rejected,cancelled',
            'notes' => 'nullable|string',
        ]));
        
        return redirect()->route('user.dashboard')->with('toast_success', 'Reservation updated successfully!');
    }

    public function destroy(Reservation $reservation)
    {
        if (auth()->id() !== $reservation->user_id) { abort(403); }
        
        if ($reservation->status !== 'pending') {
            return redirect()->route('user.dashboard')->with('toast_error', 'Cannot cancel a processed reservation.');
        }
        
        $reservation->delete();
        return redirect()->route('user.dashboard')->with('toast_success', 'Reservation cancelled successfully.');
    }
}