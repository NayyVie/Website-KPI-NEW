<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    protected $fillable = [
        'kode_unit',
        'nama_unit',
        'lokasi',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
        ];
    }

    public function subAreas(): HasMany
    {
        return $this->hasMany(SubArea::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function verifications(): HasMany
{
    return $this->hasMany(Verification::class);
}
}
