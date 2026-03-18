<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'description',
        'location',
        'capacity',
        'available_hours',
        'status',
        'created_by',
        'latitude',
        'longitude',
        'thumbnail',
        'images',
        'requested_date',
    ];

    protected $casts = [
        'available_hours' => 'integer',
        'capacity' => 'integer',
        'images' => 'array',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
