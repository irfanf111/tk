<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = ['name', 'position', 'image', 'is_active', 'bio'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
