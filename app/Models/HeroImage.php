<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroImage extends Model
{
    protected $fillable = [
        'image',
        'alt_text',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
