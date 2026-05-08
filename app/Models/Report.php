<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    protected $guarded = [];

    // ─── Relasi ────────────────────────────────────────────────────────────────

    /**
     * Laporan ini milik satu siswa (LpadStudent).
     */
    public function lpadStudent(): BelongsTo
    {
        return $this->belongsTo(LpadStudent::class, 'lpad_student_id');
    }

    /**
     * Laporan ini memiliki satu narasi capaian pembelajaran.
     */
    public function narrative(): HasOne
    {
        return $this->hasOne(ReportNarrative::class, 'report_id');
    }
}
