<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MataKuliahController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $mataKuliahs = MataKuliah::query()
            ->when($search, fn ($query) => $query->whereAny(['kode', 'nama', 'prodi'], 'like', "%{$search}%"))
            ->orderBy('semester')
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.mata-kuliahs.index', compact('mataKuliahs', 'search'));
    }

    public function create(): View
    {
        return view('admin.mata-kuliahs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        MataKuliah::create($this->validated($request));

        return redirect()->route('admin.mata-kuliahs.index')->with('success', 'Data mata kuliah berhasil ditambahkan.');
    }

    public function show(MataKuliah $mataKuliah): View
    {
        $mataKuliah->load('jadwalKuliahs.dosen');

        return view('admin.mata-kuliahs.show', compact('mataKuliah'));
    }

    public function edit(MataKuliah $mataKuliah): View
    {
        return view('admin.mata-kuliahs.edit', compact('mataKuliah'));
    }

    public function update(Request $request, MataKuliah $mataKuliah): RedirectResponse
    {
        $mataKuliah->update($this->validated($request, $mataKuliah));

        return redirect()->route('admin.mata-kuliahs.index')->with('success', 'Data mata kuliah berhasil diperbarui.');
    }

    public function destroy(MataKuliah $mataKuliah): RedirectResponse
    {
        $mataKuliah->delete();

        return redirect()->route('admin.mata-kuliahs.index')->with('success', 'Data mata kuliah berhasil dihapus.');
    }

    private function validated(Request $request, ?MataKuliah $mataKuliah = null): array
    {
        $id = $mataKuliah?->id ?? 'NULL';

        return $request->validate([
            'kode' => ['required', 'string', 'max:30', "unique:mata_kuliahs,kode,{$id}"],
            'nama' => ['required', 'string', 'max:120'],
            'sks' => ['required', 'integer', 'min:1', 'max:6'],
            'semester' => ['required', 'integer', 'min:1', 'max:14'],
            'prodi' => ['required', 'string', 'max:120'],
            'deskripsi' => ['nullable', 'string', 'max:700'],
        ]);
    }
}
