<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Competency extends Model
{
    protected $guarded = [];

    // ─── Relasi ────────────────────────────────────────────────────────────────

    /**
     * Satu kompetensi bisa memiliki banyak nilai siswa.
     */
    public function studentGrades(): HasMany
    {
        return $this->hasMany(StudentGrade::class);
    }
}
