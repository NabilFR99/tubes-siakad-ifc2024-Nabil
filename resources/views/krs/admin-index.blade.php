@extends('layouts.app')

@section('content')
<div class="mb-5">
    <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Admin</p>
    <h2 class="text-2xl font-bold">Data KRS Mahasiswa</h2>
</div>
<form class="mb-4 flex gap-2" method="GET">
    <input class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm" name="search" value="{{ $search }}" placeholder="Cari mahasiswa atau mata kuliah">
    <button class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-100" type="submit">Cari</button>
</form>
<section class="rounded-lg border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="px-5 py-3">Mahasiswa</th>
                    <th class="px-5 py-3">Mata Kuliah</th>
                    <th class="px-5 py-3">Dosen</th>
                    <th class="px-5 py-3">Jadwal</th>
                    <th class="px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($krs as $item)
                    <tr>
                        <td class="px-5 py-3">{{ $item->mahasiswa->nim }} - {{ $item->mahasiswa->nama }}</td>
                        <td class="px-5 py-3">{{ $item->jadwalKuliah->mataKuliah->kode }} - {{ $item->jadwalKuliah->mataKuliah->nama }}</td>
                        <td class="px-5 py-3">{{ $item->jadwalKuliah->dosen->nama }}</td>
                        <td class="px-5 py-3">{{ $item->jadwalKuliah->hari }} {{ substr($item->jadwalKuliah->jam_mulai, 0, 5) }}</td>
                        <td class="px-5 py-3">{{ ucfirst($item->status) }}</td>
                    </tr>
                @empty
                    <tr><td class="px-5 py-4 text-slate-500" colspan="5">Belum ada KRS.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
<div class="mt-4">{{ $krs->links() }}</div>
@endsection
