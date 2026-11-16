<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criterion extends Model
{
    protected $fillable = [
        'sub_area_id',
        'maturity_level_id',
        'kode_kriteria',
        'nama_kriteria',
        'deskripsi',
        'urutan',
    ];

    public function subArea(): BelongsTo
    {
        return $this->belongsTo(SubArea::class);
    }

    public function maturityLevel(): BelongsTo
    {
        return $this->belongsTo(MaturityLevel::class);
    }

    public function verifications(): HasMany
    {
        return $this->hasMany(Verification::class);
    }
}