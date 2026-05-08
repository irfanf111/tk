<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'akta_kelahiran',
        'kartu_keluarga',
        'ijazah_tk',
    ];

    // ─── Relasi ───────────────────────────────────────────────────────────────

    /**
     * Dokumen milik satu siswa.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    // ─── Helper ───────────────────────────────────────────────────────────────

    /**
     * Mengecek apakah semua dokumen wajib sudah diupload.
     */
    public function isComplete(): bool
    {
        return ! is_null($this->akta_kelahiran)
            && ! is_null($this->kartu_keluarga);
    }

    /**
     * Mengembalikan array daftar dokumen beserta status kelengkapannya.
     *
     * @return array<string, array<string, mixed>>
     */
    public function getStatusList(): array
    {
        return [
            'akta_kelahiran' => [
                'label'     => 'Akta Kelahiran',
                'uploaded'  => ! is_null($this->akta_kelahiran),
                'required'  => true,
                'path'      => $this->akta_kelahiran,
            ],
            'kartu_keluarga' => [
                'label'     => 'Kartu Keluarga',
                'uploaded'  => ! is_null($this->kartu_keluarga),
                'required'  => true,
                'path'      => $this->kartu_keluarga,
            ],
            'ijazah_tk' => [
                'label'     => 'Ijazah TK/PAUD Sebelumnya',
                'uploaded'  => ! is_null($this->ijazah_tk),
                'required'  => false,
                'path'      => $this->ijazah_tk,
            ],
        ];
    }
}
