<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }
}
