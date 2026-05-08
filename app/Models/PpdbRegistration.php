<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        // Identitas pendaftaran
        'nomor_pendaftaran',
        'no_pendaftaran',       // kolom lama — tetap dipertahankan
        'status',

        // A. Keterangan Siswa
        'nama_siswa',
        'nama_lengkap',         // kolom lama — alias
        'nama_panggilan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'kewarganegaraan',
        'anak_ke',
        'jml_saudara_kandung',
        'jml_saudara_tiri',
        'jml_saudara_angkat',
        'bahasa_sehari_hari',
        'berat_badan',
        'tinggi_badan',
        'golongan_darah',
        'riwayat_penyakit',
        'alamat',
        'alamat_jalan',         // kolom lama — alias
        'no_hp',
        'tinggal_bersama',
        'nik',                  // kolom lama

        // B. Orang Tua / Wali
        'nama_ayah',
        'tempat_lahir_ayah',
        'tanggal_lahir_ayah',
        'nama_ibu',
        'tempat_lahir_ibu',
        'tanggal_lahir_ibu',
        'pendidikan_ayah',
        'pendidikan_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'nama_wali',
        'pendidikan_wali',
        'hubungan_anak_wali',
        'pekerjaan_wali',
    ];

    protected $casts = [
        'tanggal_lahir'      => 'date',
        'tanggal_lahir_ayah' => 'date',
        'tanggal_lahir_ibu'  => 'date',
    ];

    // ─── Relasi ────────────────────────────────────────────────────────────────

    public function studentParent()
    {
        return $this->hasOne(StudentParent::class);
    }

    // ─── Accessor: nama terpadu (bisa dari kolom lama atau baru) ──────────────

    public function getNamaTerpaduAttribute(): string
    {
        return $this->nama_siswa ?? $this->nama_lengkap ?? '-';
    }

    public function getAlamatTerpaduAttribute(): string
    {
        return $this->alamat ?? $this->alamat_jalan ?? '-';
    }

    public function getNomorPendaftaranTerpaduAttribute(): string
    {
        return $this->nomor_pendaftaran ?? $this->no_pendaftaran ?? '-';
    }
}
