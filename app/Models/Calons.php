<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calons extends Model
{
    use HasFactory;

    protected $hidden = [
        'tempat_lahir', 'tgl_lahir', 'agama', 'perkawinan', 'disabilitas', 'status_hukum',
        'motivasi', 'riwayat_pekerjaan', 'riwayat_pendidikan', 'riwayat_organisasi',
        'riwayat_kursus_diklat', 'riwayat_penghargaan', 'created_at', 'updated_at'
    ];

    public function partai(): BelongsTo
    {
        return $this->belongsTo(Partais::class, 'partai_id');
    }

    public function dapil(): BelongsTo
    {
        return $this->belongsTo(Dapils::class, 'kode_dapil', 'kode_dapil');
    }
}
