<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PilkadaCalons extends Model
{
    use HasFactory;

    protected $table = 'pilkada_calons';

    public function paslon()
    {
        return $this->hasOne(PilkadaPaslons::class, 'kode_calon', 'kode_calon');
    }

    public function wakil_paslon()
    {
        return $this->hasOne(PilkadaPaslons::class, 'kode_wakil', 'kode_calon');
    }

    public function provinsi()
    {
        // Ensure relationships are not null and return an empty collection if they are
        $paslon = $this->paslon ?? collect();
        $wakil_paslon = $this->wakil_paslon ?? collect();

        $provinsis = $paslon->pluck('provinsi')
                        ->merge($wakil_paslon->pluck('provinsi'))
                        ->unique();

        return $provinsis;
    }

    public function kabkota()
    {
        // Ensure relationships are not null and return an empty collection if they are
        $paslon = $this->paslon ?? collect();
        $wakil_paslon = $this->wakil_paslon ?? collect();

        $kabkota = $paslon->pluck('kabkota')
                        ->merge($wakil_paslon->pluck('kabkota'))
                        ->unique();

        return $kabkota;
    }
}
