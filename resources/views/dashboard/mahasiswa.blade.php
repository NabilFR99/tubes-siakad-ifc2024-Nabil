@extends('layouts.app')

@section('content')
<div class="mb-6">
    <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Dashboard Mahasiswa</p>
    <h2 class="mt-1 text-2xl font-bold">{{ $mahasiswa->nama }}</h2>
    <p class="mt-1 text-sm text-slate-600">{{ $mahasiswa->nim }} - {{ $mahasiswa->prodi }} - {{ $mahasiswa->kelas }}</p>
</div>

<div class="grid gap-4 sm:grid-cols-2">
    <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-500">Mata Kuliah Diambil</p>
        <p class="mt-2 text-3xl font-bold">{{ $totalKrs }}</p>
    </section>
    <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-500">Total SKS</p>
        <p class="mt-2 text-3xl font-bold">{{ $totalSks }}</p>
    </section>
</div>

<section class="mt-6 rounded-lg border border-slate-200 bg-white shadow-sm">
    <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
        <h3 class="font-semibold">KRS Saya</h3>
        <a class="rounded-md bg-slate-900 px-3 py-2 text-sm font-semibold text-white hover:bg-slate-800" href="{{ route('krs.index') }}">Input KRS</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="px-5 py-3">Kode</th>
                    <th class="px-5 py-3">Mata Kuliah</th>
                    <th class="px-5 py-3">Dosen</th>
                    <th class="px-5 py-3">Jadwal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($krs as $item)
                    <tr>
                        <td class="px-5 py-3">{{ $item->jadwalKuliah->mataKuliah->kode }}</td>
                        <td class="px-5 py-3">{{ $item->jadwalKuliah->mataKuliah->nama }}</td>
                        <td class="px-5 py-3">{{ $item->jadwalKuliah->dosen->nama }}</td>
                        <td class="px-5 py-3">{{ $item->jadwalKuliah->hari }}, {{ substr($item->jadwalKuliah->jam_mulai, 0, 5) }}-{{ substr($item->jadwalKuliah->jam_selesai, 0, 5) }}</td>
                    </tr>
                @empty
                    <tr><td class="px-5 py-4 text-slate-500" colspan="4">Belum ada KRS.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
