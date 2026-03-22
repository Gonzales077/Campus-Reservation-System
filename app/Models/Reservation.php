<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'facility_id',
        'guest_name',
        'guest_contact',
        'description',
        'requested_date',
        'status',
        'available_date',
        'notes',
        'google_event_id',
        'estimated_participants'
    ];

    protected $casts = [
        'requested_date' => 'date',
        'available_date' => 'date',
    ];

    /**
     * CLINIC SYNC HELPERS
     */

    // Check if this reservation was sent from the Clinic system
    public function isFromClinic(): bool
    {
        return str_starts_with($this->guest_name, 'CLINIC:');
    }

    // Get the name without the "CLINIC: " prefix for your UI
    public function getCleanGuestNameAttribute(): string
    {
        return str_replace('CLINIC: ', '', $this->guest_name);
    }

    /**
     * RELATIONSHIPS
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    /**
     * AUTO-SYNC BACK TO CLINIC
     * When you change the status here, it updates the Clinic Database
     */
    protected static function booted()
    {
        static::updated(function ($reservation) {
            // Only proceed if this is a clinic-linked reservation
            if ($reservation->isFromClinic()) {
                try {
                    // Update the status in the Clinic system to match
                    // We match by guest_contact (email) and requested_date
                    DB::connection('clinic')
                        ->table('appointments')
                        ->where('email', $reservation->guest_contact)
                        ->where('date', $reservation->requested_date)
                        ->update([
                            'status' => ucfirst($reservation->status),
                            'updated_at' => now()
                        ]);
                } catch (\Exception $e) {
                    \Log::error("Failed to sync status back to Clinic: " . $e->getMessage());
                }
            }
        });
    }
}