<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        // Foreign keys
        'user_id',
        'ppdb_registration_id', // kolom lama — dipertahankan agar tidak merusak sistem
        'classroom_id',         // kolom lama
        'nis',                  // kolom lama

        // Identitas siswa
        'nama_lengkap',
        'nama_panggilan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'kewarganegaraan',

        // Data keluarga
        'anak_ke',
        'jumlah_saudara_kandung',
        'jumlah_saudara_tiri',
        'jumlah_saudara_angkat',
        'bahasa_sehari_hari',

        // Data fisik & kesehatan
        'berat_badan',
        'tinggi_badan',
        'golongan_darah',
        'riwayat_penyakit',

        // Kontak & tempat tinggal
        'alamat',
        'no_hp',
        'tinggal_bersama',

        // Status (kolom lama)
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected $casts = [
        'tanggal_lahir'           => 'date',
        'berat_badan'             => 'float',
        'tinggi_badan'            => 'float',
        'anak_ke'                 => 'integer',
        'jumlah_saudara_kandung'  => 'integer',
        'jumlah_saudara_tiri'     => 'integer',
        'jumlah_saudara_angkat'   => 'integer',
    ];

    // ─── Relasi PPDB ──────────────────────────────────────────────────────────

    /**
     * Siswa dimiliki oleh satu akun user (orang tua/wali yang mendaftar).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Satu siswa memiliki satu data orang tua/wali.
     */
    public function studentParent(): HasOne
    {
        return $this->hasOne(StudentParent::class);
    }

    /**
     * Satu siswa memiliki satu set dokumen persyaratan.
     */
    public function document(): HasOne
    {
        return $this->hasOne(Document::class);
    }

    /**
     * Satu siswa memiliki satu status pendaftaran resmi.
     */
    public function registration(): HasOne
    {
        return $this->hasOne(Registration::class);
    }

    /**
     * Relasi ke classroom (sistem akademik lama).
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * Relasi ke PpdbRegistration (sistem lama — backward compatibility).
     */
    public function ppdbRegistration(): BelongsTo
    {
        return $this->belongsTo(PpdbRegistration::class);
    }

    // ─── Relasi Akademik ──────────────────────────────────────────────────────

    /**
     * Satu siswa memiliki satu data LPAD (bisa null jika belum diisi).
     * Dihubungkan via student_id di lpad_students.
     */
    public function lpadStudent(): HasOne
    {
        return $this->hasOne(LpadStudent::class, 'student_id');
    }

    /**
     * Satu siswa memiliki banyak nilai (per kompetensi per semester).
     */
    public function grades(): HasMany
    {
        return $this->hasMany(StudentGrade::class);
    }

    // ─── Relasi SPP ───────────────────────────────────────────────────────────

    /**
     * Satu siswa memiliki banyak catatan pembayaran SPP.
     */
    public function sppPayments(): HasMany
    {
        return $this->hasMany(SppPayment::class);
    }

    // ─── Accessor / Helper ────────────────────────────────────────────────────

    /**
     * Mengembalikan nama lengkap sebagai representasi string model.
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->nama_lengkap ?? $this->nama_panggilan ?? 'Siswa #' . $this->id;
    }
}
