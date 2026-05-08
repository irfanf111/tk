<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolIdentity extends Model
{
    protected $fillable = [
        'school_name',
        'npsn',
        'status',
        'education_form',
        'ownership_status',
        'establishment_decree',
        'establishment_date',
        'operational_decree',
        'operational_date',
        'address',
        'hamlet',
        'village',
        'district',
        'regency',
        'province',
        'postal_code',
    ];

    protected $casts = [
        'establishment_date' => 'date',
        'operational_date'   => 'date',
    ];
}
