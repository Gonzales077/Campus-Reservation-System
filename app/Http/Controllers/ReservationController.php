<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Facility;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = auth()->user()->reservations()->with('facility')->get();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Require authentication
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to make a reservation.');
        }
        
        $facilityId = $request->query('facility');
        $facility = Facility::findOrFail($facilityId);
        
        // Check if facility is already reserved
        $hasApprovedReservation = $facility->reservations()->where('status', 'approved')->exists();
        
        if ($hasApprovedReservation) {
            return redirect()->route('user.dashboard')->with('error', 'Sorry, this facility is already reserved and unavailable for booking.');
        }
        
        return view('reservations.user-create', compact('facility'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Require authentication
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to make a reservation.');
        }
        
        // Check if facility is already reserved
        $facility = Facility::findOrFail($request->facility_id);
        $hasApprovedReservation = $facility->reservations()->where('status', 'approved')->exists();
        
        if ($hasApprovedReservation) {
            return back()->with('error', 'Sorry, this facility is already reserved and unavailable for booking.');
        }
        
        // Authenticated user reservation
        $validated = $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'description' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['guest_name'] = auth()->user()->name;
        $validated['guest_contact'] = auth()->user()->email;
        $validated['status'] = 'pending';

        Reservation::create($validated);

        return redirect()->route('user.dashboard')->with('success', 'Reservation request submitted! The admin will review your request.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        $this->authorize('update', $reservation);
        return view('reservations.edit', compact('reservation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,cancelled',
            'notes' => 'nullable|string',
        ]);

        $reservation->update($validated);

        return redirect()->route('user.dashboard')->with('success', 'Reservation updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        // Only allow users to delete their own reservations
        if (auth()->id() !== $reservation->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Only allow canceling pending reservations
        if ($reservation->status !== 'pending') {
            return redirect()->route('user.dashboard')->with('error', 'You can only cancel pending reservations.');
        }
        
        $reservation->delete();
        return redirect()->route('user.dashboard')->with('success', 'Reservation cancelled!');
    }

    public function approveReservation(Request $request, Reservation $reservation)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'available_date' => 'required|date|after:today',
        ]);

        $reservation->update([
            'status' => 'approved',
            'available_date' => $validated['available_date'],
        ]);
        
        return redirect()->back()->with('success', 'Reservation approved! Facility will be available on ' . date('M d, Y', strtotime($validated['available_date'])));
    }

    public function rejectReservation(Reservation $reservation)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $reservation->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Reservation rejected!');
    }
}
