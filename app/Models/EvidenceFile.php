<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvidenceFile extends Model
{
    protected $fillable = [
        'verification_id',
        'nama_file',
        'path_file',
        'tipe_file',
        'ukuran_file',
        'uploaded_by',
    ];

    public function verification(): BelongsTo
    {
        return $this->belongsTo(Verification::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}