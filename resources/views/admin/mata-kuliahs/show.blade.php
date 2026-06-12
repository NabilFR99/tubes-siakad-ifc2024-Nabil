@extends('layouts.app')

@section('content')
<div class="mb-5 flex items-center justify-between">
    <div>
        <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Detail Mata Kuliah</p>
        <h2 class="text-2xl font-bold">{{ $mataKuliah->nama }}</h2>
    </div>
    <a class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-100" href="{{ route('admin.mata-kuliahs.index') }}">Kembali</a>
</div>
<section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
    <dl class="grid gap-4 sm:grid-cols-2">
        <div><dt class="text-sm text-slate-500">Kode</dt><dd class="font-semibold">{{ $mataKuliah->kode }}</dd></div>
        <div><dt class="text-sm text-slate-500">SKS</dt><dd class="font-semibold">{{ $mataKuliah->sks }}</dd></div>
        <div><dt class="text-sm text-slate-500">Semester</dt><dd class="font-semibold">{{ $mataKuliah->semester }}</dd></div>
        <div><dt class="text-sm text-slate-500">Prodi</dt><dd class="font-semibold">{{ $mataKuliah->prodi }}</dd></div>
    </dl>
    <h3 class="mt-6 font-semibold">Jadwal Tersedia</h3>
    <ul class="mt-3 divide-y divide-slate-200 rounded-md border border-slate-200">
        @forelse($mataKuliah->jadwalKuliahs as $jadwal)
            <li class="px-4 py-3 text-sm">{{ $jadwal->kelas }} - {{ $jadwal->hari }} {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ $jadwal->dosen->nama }}</li>
        @empty
            <li class="px-4 py-3 text-sm text-slate-500">Belum ada jadwal.</li>
        @endforelse
    </ul>
</section>
@endsection
