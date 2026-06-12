<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DosenController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $dosens = Dosen::query()
            ->when($search, fn ($query) => $query->whereAny(['nidn', 'nama', 'email', 'prodi'], 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.dosens.index', compact('dosens', 'search'));
    }

    public function create(): View
    {
        return view('admin.dosens.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Dosen::create($this->validated($request));

        return redirect()->route('admin.dosens.index')->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function show(Dosen $dosen): View
    {
        $dosen->load('jadwalKuliahs.mataKuliah');

        return view('admin.dosens.show', compact('dosen'));
    }

    public function edit(Dosen $dosen): View
    {
        return view('admin.dosens.edit', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen): RedirectResponse
    {
        $dosen->update($this->validated($request, $dosen));

        return redirect()->route('admin.dosens.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen): RedirectResponse
    {
        $dosen->delete();

        return redirect()->route('admin.dosens.index')->with('success', 'Data dosen berhasil dihapus.');
    }

    private function validated(Request $request, ?Dosen $dosen = null): array
    {
        $id = $dosen?->id ?? 'NULL';

        return $request->validate([
            'nidn' => ['required', 'string', 'max:30', "unique:dosens,nidn,{$id}"],
            'nama' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120', "unique:dosens,email,{$id}"],
            'prodi' => ['required', 'string', 'max:120'],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ]);
    }
}
