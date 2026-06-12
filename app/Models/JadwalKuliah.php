<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalKuliah extends Model
{
    protected $fillable = [
        'mata_kuliah_id',
        'dosen_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'kelas',
        'ruang',
        'kuota',
        'tahun_akademik',
        'semester_akademik',
    ];

    public function mataKuliah(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class);
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class);
    }

    public function krs(): HasMany
    {
        return $this->hasMany(Krs::class);
    }

    public function getSisaKuotaAttribute(): int
    {
        return max(0, $this->kuota - $this->krs()->count());
    }
}
