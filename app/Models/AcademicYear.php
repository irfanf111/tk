<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ─── Relasi ────────────────────────────────────────────────────────────────

    /**
     * Satu tahun ajaran memiliki banyak kelas.
     */
    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }

    /**
     * Satu tahun ajaran memiliki banyak data nilai siswa.
     */
    public function studentGrades(): HasMany
    {
        return $this->hasMany(StudentGrade::class);
    }

    // ─── Helper ───────────────────────────────────────────────────────────────

    /**
     * Ambil tahun ajaran yang sedang aktif.
     */
    public static function getActive(): ?self
    {
        return self::where('is_active', true)->first();
    }
}
