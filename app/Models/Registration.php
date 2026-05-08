<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'status',
        'notes',
        'verified_by',
        'verified_at',
    ];

    /**
     * @return array<string, string>
     */
    protected $casts = [
        'verified_at' => 'datetime',
    ];

    // ─── Konstanta Status ─────────────────────────────────────────────────────

    const STATUS_DRAFT        = 'draft';
    const STATUS_SUBMITTED    = 'submitted';
    const STATUS_VERIFIED     = 'verified';
    const STATUS_REJECTED     = 'rejected';
    const STATUS_ACCEPTED     = 'accepted';
    const STATUS_NOT_ACCEPTED = 'not_accepted';

    /**
     * Daftar semua status yang valid beserta label tampilan.
     *
     * @return array<string, string>
     */
    public static function statusLabels(): array
    {
        return [
            self::STATUS_DRAFT        => 'Draft',
            self::STATUS_SUBMITTED    => 'Menunggu Verifikasi',
            self::STATUS_VERIFIED     => 'Terverifikasi',
            self::STATUS_REJECTED     => 'Dikembalikan',
            self::STATUS_ACCEPTED     => 'Diterima',
            self::STATUS_NOT_ACCEPTED => 'Tidak Diterima',
        ];
    }

    // ─── Relasi ───────────────────────────────────────────────────────────────

    /**
     * Pendaftaran milik satu siswa.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Admin yang melakukan verifikasi pendaftaran ini.
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // ─── Helper / Accessor ────────────────────────────────────────────────────

    /**
     * Label status yang ramah untuk ditampilkan di UI.
     */
    public function getStatusLabelAttribute(): string
    {
        return self::statusLabels()[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Mengecek apakah pendaftaran masih bisa diedit oleh pendaftar.
     */
    public function isEditable(): bool
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_REJECTED]);
    }

    /**
     * Mengecek apakah pendaftaran sudah dikirim (tidak bisa diedit lagi kecuali dikembalikan).
     */
    public function isSubmitted(): bool
    {
        return $this->status !== self::STATUS_DRAFT;
    }

    /**
     * Mengecek apakah pendaftaran sudah selesai diproses (diterima / tidak diterima).
     */
    public function isFinalized(): bool
    {
        return in_array($this->status, [self::STATUS_ACCEPTED, self::STATUS_NOT_ACCEPTED]);
    }
}
