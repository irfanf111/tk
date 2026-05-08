<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportNarrative extends Model
{
    protected $guarded = [];

    // ─── Relasi ────────────────────────────────────────────────────────────────

    /**
     * Narasi ini milik satu laporan.
     */
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class, 'report_id');
    }
}
