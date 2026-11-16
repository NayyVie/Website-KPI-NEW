<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaturityLevel extends Model
{
    protected $fillable = [
        'level',
        'nama_level',
        'deskripsi',
    ];

    public function criteria(): HasMany
    {
        return $this->hasMany(Criterion::class);
    }
}