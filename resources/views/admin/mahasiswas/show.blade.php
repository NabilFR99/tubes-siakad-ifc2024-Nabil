@extends('layouts.app')

@section('content')
<div class="mb-5 flex items-center justify-between">
    <div>
        <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Detail Mahasiswa</p>
        <h2 class="text-2xl font-bold">{{ $mahasiswa->nama }}</h2>
    </div>
    <a class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-100" href="{{ route('admin.mahasiswas.index') }}">Kembali</a>
</div>
<section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
    <dl class="grid gap-4 sm:grid-cols-2">
        <div><dt class="text-sm text-slate-500">NIM</dt><dd class="font-semibold">{{ $mahasiswa->nim }}</dd></div>
        <div><dt class="text-sm text-slate-500">Email</dt><dd class="font-semibold">{{ $mahasiswa->user->email }}</dd></div>
        <div><dt class="text-sm text-slate-500">Prodi</dt><dd class="font-semibold">{{ $mahasiswa->prodi }}</dd></div>
        <div><dt class="text-sm text-slate-500">Kelas</dt><dd class="font-semibold">{{ $mahasiswa->kelas }}</dd></div>
    </dl>
    <h3 class="mt-6 font-semibold">KRS Mahasiswa</h3>
    <div class="mt-3 overflow-x-auto rounded-md border border-slate-200">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="px-4 py-3">Kode</th>
                    <th class="px-4 py-3">Mata Kuliah</th>
                    <th class="px-4 py-3">Dosen</th>
                    <th class="px-4 py-3">Jadwal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($mahasiswa->krs as $item)
                    <tr>
                        <td class="px-4 py-3">{{ $item->jadwalKuliah->mataKuliah->kode }}</td>
                        <td class="px-4 py-3">{{ $item->jadwalKuliah->mataKuliah->nama }}</td>
                        <td class="px-4 py-3">{{ $item->jadwalKuliah->dosen->nama }}</td>
                        <td class="px-4 py-3">{{ $item->jadwalKuliah->hari }} {{ substr($item->jadwalKuliah->jam_mulai, 0, 5) }}</td>
                    </tr>
                @empty
                    <tr><td class="px-4 py-3 text-slate-500" colspan="4">Mahasiswa belum mengambil KRS.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
