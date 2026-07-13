<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TagihanSpp extends Model
{
    protected $table = 'tagihan_spps';

    protected $fillable = [
        'siswa_id',
        'bulan_tagihan',
        'total_tagihan',
        'tenggat_pembayaran',
        'status',
        'tanggal_pembayaran',
    ];

    protected $casts = [
        'tenggat_pembayaran' => 'date',
        'tanggal_pembayaran' => 'date',
        'total_tagihan' => 'integer',
    ];

    /**
     * Relasi ke model Siswa.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
