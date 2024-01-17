<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partais extends Model
{
    use HasFactory;

    public function calons(): HasMany
    {
        return $this->hasMany(Calons::class, 'partai_id');
    }
}
