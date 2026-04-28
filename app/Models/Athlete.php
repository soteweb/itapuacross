<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    protected $fillable = [
        'name',
        'last_name',
        'identity_document',
        'email',
        'phone',
        'gender',
        'blood_type',
        'club',
        'carnet_number',
        'date_of_birth',
        'city',
        'country',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
