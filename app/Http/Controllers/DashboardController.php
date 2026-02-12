<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Reservation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function userDashboard()
    {
        // Get only facilities that don't have approved reservations
        $facilities = Facility::where('status', 'active')
            ->whereDoesntHave('reservations', function($query) {
                $query->where('status', 'approved');
            })
            ->get();
        
        $reservations = Reservation::where('user_id', auth()->id())->latest()->get();
        return view('dashboards.user', compact('facilities', 'reservations'));
    }

    public function adminDashboard()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $facilities = auth()->user()->facilities;
        $pendingReservations = Reservation::whereIn('facility_id', $facilities->pluck('id'))->where('status', 'pending')->get();
        $approvedReservations = Reservation::whereIn('facility_id', $facilities->pluck('id'))->where('status', 'approved')->get();
        $allReservations = Reservation::whereIn('facility_id', $facilities->pluck('id'))->latest()->get();

        return view('dashboards.admin', compact('facilities', 'pendingReservations', 'approvedReservations', 'allReservations'));
    }
}
