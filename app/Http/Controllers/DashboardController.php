<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Reservation;
use App\Models\Message;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function userDashboard(Request $request)
    {
        // Get only facilities that don't have approved reservations
        $facilities = Facility::where('status', 'active')
            ->whereDoesntHave('reservations', function($query) {
                $query->where('status', 'approved');
            })
            ->get();
        
        // Paginated user reservations (10 per page)
        $reservations = Reservation::where('user_id', auth()->id())
            ->latest()
            ->paginate(10, ['*'], 'user_res_page')
            ->withQueryString();

        return view('dashboards.user', compact('facilities', 'reservations'));
    }

    public function adminDashboard(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $facilityIds = auth()->user()->facilities->pluck('id');

        // 1. PENDING RESERVATIONS + Search
        $pendingQuery = Reservation::whereIn('facility_id', $facilityIds)->where('status', 'pending');
        if ($request->filled('search_pending')) {
            $pendingQuery->where(function($q) use ($request) {
                $term = '%' . $request->search_pending . '%';
                $q->where('reservation_number', 'like', $term)
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', $term));
            });
        }
        $pendingReservations = $pendingQuery->paginate(10, ['*'], 'pending_page')->withQueryString();

        // 2. APPROVED RESERVATIONS + Search
        $approvedQuery = Reservation::whereIn('facility_id', $facilityIds)->where('status', 'approved');
        if ($request->filled('search_approved')) {
            $approvedQuery->where(function($q) use ($request) {
                $term = '%' . $request->search_approved . '%';
                $q->where('reservation_number', 'like', $term)
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', $term));
            });
        }
        $approvedReservations = $approvedQuery->paginate(10, ['*'], 'approved_page')->withQueryString();

        // 3. ALL RESERVATIONS HISTORY + Search
        $historyQuery = Reservation::whereIn('facility_id', $facilityIds)->latest();
        if ($request->filled('search_history')) {
            $historyQuery->where(function($q) use ($request) {
                $term = '%' . $request->search_history . '%';
                $q->where('reservation_number', 'like', $term)
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', $term));
            });
        }
        $allReservations = $historyQuery->paginate(10, ['*'], 'history_page')->withQueryString();

        $facilities = auth()->user()->facilities;
        $unreadMessagesCount = Message::whereNull('read_at')->count();

        return view('dashboards.admin', compact(
            'facilities', 
            'pendingReservations', 
            'approvedReservations', 
            'allReservations', 
            'unreadMessagesCount'
        ));
    }

    /**
     * Update admin's Gmail address
     */
    public function updateGmailAddress(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'gmail_address' => 'required|email|unique:users,gmail_address,' . auth()->id(),
        ]);

        auth()->user()->update([
            'gmail_address' => $validated['gmail_address'],
        ]);

        return redirect()->back()->with('success', 'Gmail address updated successfully!');
    }
}