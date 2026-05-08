<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentParent extends Model
{
    use HasFactory;

    protected $table = 'student_parents';

    protected $fillable = [
        // Foreign keys
        'student_id',
        'ppdb_registration_id', // kolom lama — dipertahankan

        // ── Data Ayah ──
        'nama_ayah',
        'tempat_lahir_ayah',
        'tanggal_lahir_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',

        // ── Data Ibu ──
        'nama_ibu',
        'tempat_lahir_ibu',
        'tanggal_lahir_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',

        // ── Data Wali (opsional) ──
        'nama_wali',
        'pendidikan_wali',
        'hubungan_wali',
        'pekerjaan_wali',

        // Kolom lama
        'no_hp_ortu',
        'penghasilan',
    ];

    /**
     * @return array<string, string>
     */
    protected $casts = [
        'tanggal_lahir_ayah' => 'date',
        'tanggal_lahir_ibu'  => 'date',
    ];

    // ─── Relasi ───────────────────────────────────────────────────────────────

    /**
     * Data orang tua/wali milik satu siswa.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relasi ke PpdbRegistration (sistem lama — backward compatibility).
     */
    public function ppdbRegistration(): BelongsTo
    {
        return $this->belongsTo(PpdbRegistration::class);
    }
}
