<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Student
{
    protected $table = 'students';

    /**
     * Scope untuk menyaring siswa yang aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Relasi ke model TagihanSpp.
     */
    public function tagihanSpps(): HasMany
    {
        return $this->hasMany(TagihanSpp::class, 'siswa_id');
    }

    /**
     * Accessor untuk masa aktif awal siswa.
     * Menggunakan created_at sebagai masa aktif awal, atau fallback ke tanggal sekarang.
     */
    public function getMasaAktifAwalAttribute()
    {
        return $this->created_at ?? now();
    }
}
