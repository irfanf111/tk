<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LpadStudent extends Model
{
    protected $table = 'lpad_students';

    protected $guarded = [];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // ─── Relasi ────────────────────────────────────────────────────────────────

    /**
     * Seorang murid memiliki banyak laporan (berbeda semester/tahun ajaran).
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'lpad_student_id');
    }

    // ─── Accessor ──────────────────────────────────────────────────────────────

    /**
     * Menghitung usia anak berdasarkan tanggal_lahir.
     * Format output: "5 Tahun 2 Bulan"
     *
     * @return string
     */
    public function getUsiaAttribute(): string
    {
        $lahir = Carbon::parse($this->tanggal_lahir);
        $now   = Carbon::now();

        $tahun = $lahir->diffInYears($now);
        $bulan = $lahir->copy()->addYears($tahun)->diffInMonths($now);

        return "{$tahun} Tahun {$bulan} Bulan";
    }
}
