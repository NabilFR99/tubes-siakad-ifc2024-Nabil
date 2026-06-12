@extends('layouts.app')

@section('content')
<div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Admin</p>
        <h2 class="text-2xl font-bold">Data Dosen</h2>
    </div>
    <a class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800" href="{{ route('admin.dosens.create') }}">Tambah Dosen</a>
</div>

<form class="mb-4 flex gap-2" method="GET">
    <input class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm" name="search" value="{{ $search }}" placeholder="Cari NIDN, nama, email, prodi">
    <button class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-100" type="submit">Cari</button>
</form>

<section class="rounded-lg border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="px-5 py-3">NIDN</th>
                    <th class="px-5 py-3">Nama</th>
                    <th class="px-5 py-3">Email</th>
                    <th class="px-5 py-3">Prodi</th>
                    <th class="px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($dosens as $dosen)
                    <tr>
                        <td class="px-5 py-3">{{ $dosen->nidn }}</td>
                        <td class="px-5 py-3 font-medium">{{ $dosen->nama }}</td>
                        <td class="px-5 py-3">{{ $dosen->email }}</td>
                        <td class="px-5 py-3">{{ $dosen->prodi }}</td>
                        <td class="px-5 py-3">
                            <div class="flex gap-2">
                                <a class="rounded-md border border-slate-300 px-3 py-1.5 font-semibold hover:bg-slate-100" href="{{ route('admin.dosens.show', $dosen) }}">Lihat</a>
                                <a class="rounded-md border border-slate-300 px-3 py-1.5 font-semibold hover:bg-slate-100" href="{{ route('admin.dosens.edit', $dosen) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.dosens.destroy', $dosen) }}" onsubmit="return confirm('Hapus data dosen ini?')">
                                    @csrf @method('DELETE')
                                    <button class="rounded-md border border-red-300 px-3 py-1.5 font-semibold text-red-700 hover:bg-red-50" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td class="px-5 py-4 text-slate-500" colspan="5">Data dosen belum tersedia.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<div class="mt-4">{{ $dosens->links() }}</div>
@endsection
