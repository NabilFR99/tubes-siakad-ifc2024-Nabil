@extends('layouts.app')

@section('content')
<div class="mb-5">
    <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Mahasiswa</p>
    <h2 class="text-2xl font-bold">Input KRS</h2>
    <p class="mt-1 text-sm text-slate-600">{{ $mahasiswa->nim }} - {{ $mahasiswa->nama }}</p>
</div>

@if($errors->any())
    <div class="mb-5 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
@endif

<section class="mb-6 rounded-lg border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 px-5 py-4">
        <h3 class="font-semibold">KRS Saya</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="px-5 py-3">Mata Kuliah</th>
                    <th class="px-5 py-3">Dosen</th>
                    <th class="px-5 py-3">Jadwal</th>
                    <th class="px-5 py-3">SKS</th>
                    <th class="px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($krs as $item)
                    <tr>
                        <td class="px-5 py-3">{{ $item->jadwalKuliah->mataKuliah->kode }} - {{ $item->jadwalKuliah->mataKuliah->nama }}</td>
                        <td class="px-5 py-3">{{ $item->jadwalKuliah->dosen->nama }}</td>
                        <td class="px-5 py-3">{{ $item->jadwalKuliah->hari }} {{ substr($item->jadwalKuliah->jam_mulai, 0, 5) }}</td>
                        <td class="px-5 py-3">{{ $item->jadwalKuliah->mataKuliah->sks }}</td>
                        <td class="px-5 py-3">
                            <form method="POST" action="{{ route('krs.destroy', $item) }}" onsubmit="return confirm('Drop mata kuliah ini?')">
                                @csrf @method('DELETE')
                                <button class="rounded-md border border-red-300 px-3 py-1.5 font-semibold text-red-700 hover:bg-red-50" type="submit">Drop</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td class="px-5 py-4 text-slate-500" colspan="5">Belum ada KRS.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h3 class="font-semibold">Jadwal Tersedia</h3>
    <form class="flex gap-2" method="GET">
        <input class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm" name="search" value="{{ $search }}" placeholder="Cari jadwal">
        <button class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-100" type="submit">Cari</button>
    </form>
</div>

<section class="rounded-lg border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="px-5 py-3">Mata Kuliah</th>
                    <th class="px-5 py-3">Dosen</th>
                    <th class="px-5 py-3">Jadwal</th>
                    <th class="px-5 py-3">Kuota</th>
                    <th class="px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($availableJadwal as $jadwal)
                    <tr>
                        <td class="px-5 py-3">{{ $jadwal->mataKuliah->kode }} - {{ $jadwal->mataKuliah->nama }} ({{ $jadwal->mataKuliah->sks }} SKS)</td>
                        <td class="px-5 py-3">{{ $jadwal->dosen->nama }}</td>
                        <td class="px-5 py-3">{{ $jadwal->hari }} {{ substr($jadwal->jam_mulai, 0, 5) }}-{{ substr($jadwal->jam_selesai, 0, 5) }}, {{ $jadwal->ruang }}</td>
                        <td class="px-5 py-3">{{ $jadwal->krs_count }} / {{ $jadwal->kuota }}</td>
                        <td class="px-5 py-3">
                            <form method="POST" action="{{ route('krs.store') }}">
                                @csrf
                                <input name="jadwal_kuliah_id" type="hidden" value="{{ $jadwal->id }}">
                                <button class="rounded-md bg-slate-900 px-3 py-1.5 font-semibold text-white hover:bg-slate-800" type="submit">Ambil</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td class="px-5 py-4 text-slate-500" colspan="5">Tidak ada jadwal tersedia.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
<div class="mt-4">{{ $availableJadwal->links() }}</div>
@endsection
