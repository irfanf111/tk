<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LpadStudent extends Model
{
    use HasFactory;

    protected $table = 'lpad_students';

    protected $guarded = [];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // ─── Relasi ────────────────────────────────────────────────────────────────

    /**
     * LpadStudent terhubung ke data siswa PPDB (students).
     * Nullable karena data lama mungkin belum punya student_id.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Seorang murid memiliki banyak laporan (berbeda semester/tahun ajaran).
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'lpad_student_id');
    }

    // ─── Accessor ──────────────────────────────────────────────────────────────

    public function getUsiaAttribute(): string
    {
        return $this->getUsiaAt(now());
    }

    /**
     * Menghitung usia anak pada tanggal tertentu.
     * Format output: "5 Tahun 2 Bulan"
     */
    public function getUsiaAt($date): string
    {
        if (!$this->tanggal_lahir) {
            return '—';
        }
        
        $lahir  = Carbon::parse($this->tanggal_lahir);
        $target = Carbon::parse($date);

        $tahun = (int) $lahir->diffInYears($target);
        $bulan = (int) $lahir->copy()->addYears($tahun)->diffInMonths($target);

        return "{$tahun} Tahun {$bulan} Bulan";
    }

    /**
     * Mengembalikan nama lengkap — prioritas dari relasi student jika ada.
     */
    public function getNamaAttribute(): string
    {
        return $this->student?->nama_lengkap ?? $this->nama_lengkap;
    }
}
