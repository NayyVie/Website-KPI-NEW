<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubArea extends Model
{
    protected $fillable = [
        'kode_sub_area',
        'nama_sub_area',
        'deskripsi',
        'urutan',
        'aktif',
    ];

    public function criteria(): HasMany
    {
        return $this->hasMany(Criterion::class);
    }

    public function unit(): BelongsTo
{
    return $this->belongsTo(Unit::class);
}
    
}