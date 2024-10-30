<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function pilkada_paslon()
    {
        return $this->hasMany(PilkadaPaslons::class, 'kode_wilayah', 'kode_wilayah');
    }    
}
