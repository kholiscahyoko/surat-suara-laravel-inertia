<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calons extends Model
{
    use HasFactory;

    public function partai(): BelongsTo
    {
        return $this->belongsTo(Partais::class, 'partai_id');
    }

    public function dapil(): BelongsTo
    {
        return $this->belongsTo(Dapils::class, 'kode_dapil', 'kode_dapil');
    }
}
