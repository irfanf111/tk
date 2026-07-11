<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentGrade extends Model
{
    protected $guarded = [];

    protected $casts = [
        'semester' => 'string',
    ];

    // ─── Relasi ────────────────────────────────────────────────────────────────

    /**
     * Nilai ini milik satu siswa.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Nilai ini untuk tahun ajaran tertentu.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Nilai ini untuk kompetensi tertentu.
     */
    public function competency(): BelongsTo
    {
        return $this->belongsTo(Competency::class);
    }

    // ─── Accessor ──────────────────────────────────────────────────────────────

    /**
     * Label semester yang lebih ramah dibaca.
     */
    public function getSemesterLabelAttribute(): string
    {
        return $this->semester === '1' ? 'Semester 1' : 'Semester 2';
    }
}
