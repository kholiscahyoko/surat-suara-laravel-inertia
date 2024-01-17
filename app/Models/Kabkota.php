<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kabkota extends Model
{
    use HasFactory;

    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'id_provinsi');
    }

}
