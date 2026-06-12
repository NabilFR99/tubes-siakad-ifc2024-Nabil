<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\JadwalKuliah;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return view('dashboard.admin', [
                'totalMahasiswa' => Mahasiswa::count(),
                'totalDosen' => Dosen::count(),
                'totalMataKuliah' => MataKuliah::count(),
                'totalJadwal' => JadwalKuliah::count(),
                'totalKrs' => Krs::count(),
                'latestKrs' => Krs::with(['mahasiswa', 'jadwalKuliah.mataKuliah'])->latest()->take(5)->get(),
            ]);
        }

        $mahasiswa = $user->mahasiswa()->firstOrFail();

        return view('dashboard.mahasiswa', [
            'mahasiswa' => $mahasiswa,
            'totalKrs' => $mahasiswa->krs()->count(),
            'totalSks' => $mahasiswa->krs()
                ->join('jadwal_kuliahs', 'krs.jadwal_kuliah_id', '=', 'jadwal_kuliahs.id')
                ->join('mata_kuliahs', 'jadwal_kuliahs.mata_kuliah_id', '=', 'mata_kuliahs.id')
                ->sum('mata_kuliahs.sks'),
            'krs' => $mahasiswa->krs()->with(['jadwalKuliah.mataKuliah', 'jadwalKuliah.dosen'])->latest()->take(5)->get(),
        ]);
    }
}
