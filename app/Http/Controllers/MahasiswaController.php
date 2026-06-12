<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $mahasiswas = Mahasiswa::with('user')
            ->when($search, fn ($query) => $query->whereAny(['nim', 'nama', 'prodi', 'kelas'], 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.mahasiswas.index', compact('mahasiswas', 'search'));
    }

    public function create(): View
    {
        return view('admin.mahasiswas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $user = User::create([
            'name' => $data['nama'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'mahasiswa',
        ]);

        Mahasiswa::create($this->mahasiswaData($data) + ['user_id' => $user->id]);

        return redirect()->route('admin.mahasiswas.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function show(Mahasiswa $mahasiswa): View
    {
        $mahasiswa->load(['user', 'krs.jadwalKuliah.mataKuliah', 'krs.jadwalKuliah.dosen']);

        return view('admin.mahasiswas.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa): View
    {
        $mahasiswa->load('user');

        return view('admin.mahasiswas.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $data = $this->validated($request, $mahasiswa);

        $mahasiswa->user->update(array_filter([
            'name' => $data['nama'],
            'email' => $data['email'],
            'password' => $data['password'] ?? null,
        ]));

        $mahasiswa->update($this->mahasiswaData($data));

        return redirect()->route('admin.mahasiswas.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
        $mahasiswa->user()->delete();

        return redirect()->route('admin.mahasiswas.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    private function validated(Request $request, ?Mahasiswa $mahasiswa = null): array
    {
        $userId = $mahasiswa?->user_id;
        $mahasiswaId = $mahasiswa?->id ?? 'NULL';

        return $request->validate([
            'nim' => ['required', 'string', 'max:30', "unique:mahasiswas,nim,{$mahasiswaId}"],
            'nama' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120', Rule::unique('users', 'email')->ignore($userId)],
            'password' => [$mahasiswa ? 'nullable' : 'required', 'string', 'min:8'],
            'prodi' => ['required', 'string', 'max:120'],
            'angkatan' => ['required', 'integer', 'min:2000', 'max:2100'],
            'kelas' => ['required', 'string', 'max:20'],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ]);
    }

    private function mahasiswaData(array $data): array
    {
        return collect($data)->only([
            'nim',
            'nama',
            'prodi',
            'angkatan',
            'kelas',
            'no_hp',
            'alamat',
        ])->all();
    }
}
