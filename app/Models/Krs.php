<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Krs extends Model
{
    protected $table = 'krs';

    protected $fillable = [
        'mahasiswa_id',
        'jadwal_kuliah_id',
        'tahun_akademik',
        'semester',
        'status',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function jadwalKuliah(): BelongsTo
    {
        return $this->belongsTo(JadwalKuliah::class);
    }
}
