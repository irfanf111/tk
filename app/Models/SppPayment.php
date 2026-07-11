<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class SppPayment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'nominal'       => 'integer',
    ];

    // ─── Relasi ────────────────────────────────────────────────────────────────

    /**
     * Pembayaran ini milik satu siswa.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Pembayaran ini dicatat oleh satu admin/user.
     */
    public function pencatat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }

    // ─── Accessor ──────────────────────────────────────────────────────────────

    /**
     * Mengubah format bulan 'YYYY-MM' menjadi label yang lebih ramah baca.
     * Contoh: '2026-07' → 'Juli 2026'
     */
    public function getBulanLabelAttribute(): string
    {
        if (! $this->bulan) {
            return '—';
        }

        try {
            return Carbon::createFromFormat('Y-m', $this->bulan)->translatedFormat('F Y');
        } catch (\Exception $e) {
            return $this->bulan;
        }
    }

    /**
     * Format nominal sebagai rupiah.
     * Contoh: 150000 → 'Rp 150.000'
     */
    public function getNominalFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    /**
     * Filter pembayaran yang lunas.
     */
    public function scopeLunas($query)
    {
        return $query->where('status', 'lunas');
    }

    /**
     * Filter pembayaran yang belum lunas.
     */
    public function scopeBelum($query)
    {
        return $query->where('status', 'belum');
    }
}
