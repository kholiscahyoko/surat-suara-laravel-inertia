<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PilkadaPaslons extends Model
{
    use HasFactory;

    protected $table = 'pilkada_pasangans';

    public function calon()
    {
        return $this->belongsTo(PilkadaCalons::class, 'kode_calon', 'kode_calon');
    }

    public function wakil_calon()
    {
        return $this->belongsTo(PilkadaCalons::class, 'kode_wakil', 'kode_calon');
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'kode_wilayah', 'kode_wilayah');
    }

    public function kabkota()
    {
        return $this->belongsTo(Kabkota::class, 'kode_wilayah', 'kode_wilayah');
    }
}
