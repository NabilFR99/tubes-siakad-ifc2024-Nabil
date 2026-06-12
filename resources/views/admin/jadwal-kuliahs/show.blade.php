@extends('layouts.app')

@section('content')
<div class="mb-5 flex items-center justify-between">
    <div>
        <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Detail Jadwal</p>
        <h2 class="text-2xl font-bold">{{ $jadwalKuliah->mataKuliah->nama }}</h2>
    </div>
    <a class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-100" href="{{ route('admin.jadwal-kuliahs.index') }}">Kembali</a>
</div>
<section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
    <dl class="grid gap-4 sm:grid-cols-2">
        <div><dt class="text-sm text-slate-500">Dosen</dt><dd class="font-semibold">{{ $jadwalKuliah->dosen->nama }}</dd></div>
        <div><dt class="text-sm text-slate-500">Waktu</dt><dd class="font-semibold">{{ $jadwalKuliah->hari }}, {{ substr($jadwalKuliah->jam_mulai, 0, 5) }}-{{ substr($jadwalKuliah->jam_selesai, 0, 5) }}</dd></div>
        <div><dt class="text-sm text-slate-500">Kelas/Ruang</dt><dd class="font-semibold">{{ $jadwalKuliah->kelas }} / {{ $jadwalKuliah->ruang }}</dd></div>
        <div><dt class="text-sm text-slate-500">Kuota</dt><dd class="font-semibold">{{ $jadwalKuliah->krs->count() }} / {{ $jadwalKuliah->kuota }}</dd></div>
    </dl>
    <h3 class="mt-6 font-semibold">Mahasiswa Mengambil Jadwal Ini</h3>
    <ul class="mt-3 divide-y divide-slate-200 rounded-md border border-slate-200">
        @forelse($jadwalKuliah->krs as $item)
            <li class="px-4 py-3 text-sm">{{ $item->mahasiswa->nim }} - {{ $item->mahasiswa->nama }}</li>
        @empty
            <li class="px-4 py-3 text-sm text-slate-500">Belum ada mahasiswa.</li>
        @endforelse
    </ul>
</section>
@endsection
