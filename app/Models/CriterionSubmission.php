<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CriterionSubmission extends Model
{
    protected $fillable = [
        'unit_id',
        'criterion_id',
        'file_bukti',
        'status_verifikasi',
        'catatan_admin',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class);
    }
}
