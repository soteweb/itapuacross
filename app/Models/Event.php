<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'featured_image',
        'date',
        'location_address',
        'latitude',
        'longitude',
        'is_active',
        'event_type_id',
        'google_maps_url',
        'registration_type',
        'external_registration_url',
        'registration_settings'
    ];

    protected $casts = [
        'date' => 'date',
        'registration_settings' => 'array',
    ];

    public function categories()
    {
        return $this->hasMany(EventCategory::class);
    }

    public function distances()
    {
        return $this->hasMany(EventDistance::class);
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }
}
