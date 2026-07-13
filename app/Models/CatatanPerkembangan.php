<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatatanPerkembangan extends Model
{
    protected $table = 'catatan_perkembangans';

    protected $fillable = [
        'siswa_id',
        'kompetensi_id',
        'status_pencapaian',
        'catatan_khusus',
    ];

    /**
     * Relasi ke model Siswa / Student.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'siswa_id');
    }

    /**
     * Relasi ke model Competency.
     */
    public function kompetensi(): BelongsTo
    {
        return $this->belongsTo(Competency::class, 'kompetensi_id');
    }
}
