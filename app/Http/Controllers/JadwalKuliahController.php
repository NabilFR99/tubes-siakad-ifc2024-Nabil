<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\JadwalKuliah;
use App\Models\MataKuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JadwalKuliahController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $jadwalKuliahs = JadwalKuliah::with(['mataKuliah', 'dosen'])
            ->when($search, function ($query) use ($search): void {
                $query->where('hari', 'like', "%{$search}%")
                    ->orWhere('kelas', 'like', "%{$search}%")
                    ->orWhere('ruang', 'like', "%{$search}%")
                    ->orWhereHas('mataKuliah', fn ($q) => $q->where('nama', 'like', "%{$search}%")->orWhere('kode', 'like', "%{$search}%"))
                    ->orWhereHas('dosen', fn ($q) => $q->where('nama', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.jadwal-kuliahs.index', compact('jadwalKuliahs', 'search'));
    }

    public function create(): View
    {
        return view('admin.jadwal-kuliahs.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        JadwalKuliah::create($this->validated($request));

        return redirect()->route('admin.jadwal-kuliahs.index')->with('success', 'Data jadwal berhasil ditambahkan.');
    }

    public function show(JadwalKuliah $jadwalKuliah): View
    {
        $jadwalKuliah->load(['mataKuliah', 'dosen', 'krs.mahasiswa']);

        return view('admin.jadwal-kuliahs.show', compact('jadwalKuliah'));
    }

    public function edit(JadwalKuliah $jadwalKuliah): View
    {
        return view('admin.jadwal-kuliahs.edit', $this->formData() + compact('jadwalKuliah'));
    }

    public function update(Request $request, JadwalKuliah $jadwalKuliah): RedirectResponse
    {
        $jadwalKuliah->update($this->validated($request, $jadwalKuliah));

        return redirect()->route('admin.jadwal-kuliahs.index')->with('success', 'Data jadwal berhasil diperbarui.');
    }

    public function destroy(JadwalKuliah $jadwalKuliah): RedirectResponse
    {
        $jadwalKuliah->delete();

        return redirect()->route('admin.jadwal-kuliahs.index')->with('success', 'Data jadwal berhasil dihapus.');
    }

    private function formData(): array
    {
        return [
            'dosens' => Dosen::orderBy('nama')->get(),
            'mataKuliahs' => MataKuliah::orderBy('nama')->get(),
            'hariList' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
        ];
    }

    private function validated(Request $request, ?JadwalKuliah $jadwalKuliah = null): array
    {
        return $request->validate([
            'mata_kuliah_id' => ['required', 'exists:mata_kuliahs,id'],
            'dosen_id' => ['required', 'exists:dosens,id'],
            'hari' => ['required', 'string', 'max:20'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'kelas' => ['required', 'string', 'max:20'],
            'ruang' => ['required', 'string', 'max:60'],
            'kuota' => ['required', 'integer', 'min:1', 'max:200'],
            'tahun_akademik' => ['required', 'string', 'max:20'],
            'semester_akademik' => [
                'required',
                'string',
                'max:20',
                Rule::unique('jadwal_kuliahs', 'semester_akademik')
                    ->where('mata_kuliah_id', $request->integer('mata_kuliah_id'))
                    ->where('kelas', $request->input('kelas'))
                    ->where('tahun_akademik', $request->input('tahun_akademik'))
                    ->ignore($jadwalKuliah?->id),
            ],
        ]);
    }
}
