<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model
{
    protected $fillable = [
        'nidn',
        'nama',
        'email',
        'prodi',
        'no_hp',
        'alamat',
    ];

    public function jadwalKuliahs(): HasMany
    {
        return $this->hasMany(JadwalKuliah::class);
    }
}
