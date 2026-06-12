<?php

namespace App\Http\Controllers;

use App\Models\JadwalKuliah;
use App\Models\Krs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class KrsController extends Controller
{
    public function adminIndex(Request $request): View
    {
        $search = $request->string('search')->toString();

        $krs = Krs::with(['mahasiswa', 'jadwalKuliah.mataKuliah', 'jadwalKuliah.dosen'])
            ->when($search, function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->whereHas('mahasiswa', fn ($q) => $q->where('nama', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%"))
                        ->orWhereHas('jadwalKuliah.mataKuliah', fn ($q) => $q->where('nama', 'like', "%{$search}%")->orWhere('kode', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('krs.admin-index', compact('krs', 'search'));
    }

    public function index(Request $request): View
    {
        $mahasiswa = $request->user()->mahasiswa()->firstOrFail();
        $search = $request->string('search')->toString();
        $takenMataKuliahIds = $mahasiswa->krs()
            ->join('jadwal_kuliahs', 'krs.jadwal_kuliah_id', '=', 'jadwal_kuliahs.id')
            ->pluck('jadwal_kuliahs.mata_kuliah_id');

        $availableJadwal = JadwalKuliah::with(['mataKuliah', 'dosen'])
            ->withCount('krs')
            ->whereNotIn('mata_kuliah_id', $takenMataKuliahIds)
            ->when($search, function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->whereHas('mataKuliah', fn ($q) => $q->where('nama', 'like', "%{$search}%")->orWhere('kode', 'like', "%{$search}%"))
                        ->orWhereHas('dosen', fn ($q) => $q->where('nama', 'like', "%{$search}%"))
                        ->orWhere('hari', 'like', "%{$search}%")
                        ->orWhere('kelas', 'like', "%{$search}%");
                });
            })
            ->orderBy('hari')
            ->paginate(10)
            ->withQueryString();

        $krs = $mahasiswa->krs()->with(['jadwalKuliah.mataKuliah', 'jadwalKuliah.dosen'])->latest()->get();

        return view('krs.index', compact('mahasiswa', 'availableJadwal', 'krs', 'search'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'jadwal_kuliah_id' => ['required', 'exists:jadwal_kuliahs,id'],
        ]);

        $mahasiswa = $request->user()->mahasiswa()->firstOrFail();
        $jadwal = JadwalKuliah::withCount('krs')->findOrFail($data['jadwal_kuliah_id']);

        if ($jadwal->krs_count >= $jadwal->kuota) {
            return back()->withErrors(['jadwal_kuliah_id' => 'Kuota jadwal ini sudah penuh.']);
        }

        if ($mahasiswa->krs()->whereHas('jadwalKuliah', fn ($query) => $query->where('mata_kuliah_id', $jadwal->mata_kuliah_id))->exists()) {
            return back()->withErrors(['jadwal_kuliah_id' => 'Mata kuliah ini sudah ada di KRS Anda.']);
        }

        $conflictingKrs = $mahasiswa->krs()
            ->with('jadwalKuliah.mataKuliah')
            ->whereHas('jadwalKuliah', function ($query) use ($jadwal): void {
                $query->where('hari', $jadwal->hari)
                    ->where('tahun_akademik', $jadwal->tahun_akademik)
                    ->where('semester_akademik', $jadwal->semester_akademik)
                    ->where('jam_mulai', '<', $jadwal->jam_selesai)
                    ->where('jam_selesai', '>', $jadwal->jam_mulai);
            })
            ->first();

        if ($conflictingKrs) {
            return back()->withErrors([
                'jadwal_kuliah_id' => 'Jadwal bentrok dengan '.$conflictingKrs->jadwalKuliah->mataKuliah->nama.'.',
            ]);
        }

        DB::table('krs')->insert([
            'mahasiswa_id' => $mahasiswa->id,
            'jadwal_kuliah_id' => $jadwal->id,
            'tahun_akademik' => $jadwal->tahun_akademik,
            'semester' => $jadwal->semester_akademik,
            'status' => 'diambil',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('krs.index')->with('success', 'Mata kuliah berhasil ditambahkan ke KRS.');
    }

    public function destroy(Request $request, Krs $krs): RedirectResponse
    {
        $mahasiswa = $request->user()->mahasiswa()->firstOrFail();

        abort_unless($krs->mahasiswa_id === $mahasiswa->id, 403);

        $krs->delete();

        return redirect()->route('krs.index')->with('success', 'Mata kuliah berhasil dihapus dari KRS.');
    }

    public function schedule(Request $request): View
    {
        $mahasiswa = $request->user()->mahasiswa()->firstOrFail();
        $krs = $mahasiswa->krs()->with(['jadwalKuliah.mataKuliah', 'jadwalKuliah.dosen'])->get();

        return view('krs.schedule', compact('mahasiswa', 'krs'));
    }
}
