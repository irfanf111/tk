<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = ['title', 'event_date', 'description'];

    protected $casts = [
        'event_date' => 'date',
    ];
}
