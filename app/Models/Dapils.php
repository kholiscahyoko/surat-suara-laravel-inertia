<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dapils extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function calons(): HasMany
    {
        return $this->hasMany(Calons::class, 'kode_dapil', 'kode_dapil');
    }

    public function kursi_dapil(): HasOne
    {
        return $this->HasOne(Kursidapils::class, 'id_dapil');
    }
}
