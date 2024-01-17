<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kecamatan extends Model
{
    use HasFactory;

    public function kabkota(): BelongsTo
    {
        return $this->belongsTo(Kabkota::class, 'id_kabkota');
    }
}
