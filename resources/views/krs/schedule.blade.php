@extends('layouts.app')

@section('content')
<div class="mb-5">
    <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Mahasiswa</p>
    <h2 class="text-2xl font-bold">Jadwal Saya</h2>
    <p class="mt-1 text-sm text-slate-600">{{ $mahasiswa->nim }} - {{ $mahasiswa->nama }}</p>
</div>

<section class="rounded-lg border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="px-5 py-3">Hari</th>
                    <th class="px-5 py-3">Jam</th>
                    <th class="px-5 py-3">Mata Kuliah</th>
                    <th class="px-5 py-3">Dosen</th>
                    <th class="px-5 py-3">Ruang</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($krs as $item)
                    <tr>
                        <td class="px-5 py-3 font-medium">{{ $item->jadwalKuliah->hari }}</td>
                        <td class="px-5 py-3">{{ substr($item->jadwalKuliah->jam_mulai, 0, 5) }}-{{ substr($item->jadwalKuliah->jam_selesai, 0, 5) }}</td>
                        <td class="px-5 py-3">{{ $item->jadwalKuliah->mataKuliah->nama }}</td>
                        <td class="px-5 py-3">{{ $item->jadwalKuliah->dosen->nama }}</td>
                        <td class="px-5 py-3">{{ $item->jadwalKuliah->ruang }}</td>
                    </tr>
                @empty
                    <tr><td class="px-5 py-4 text-slate-500" colspan="5">Belum ada jadwal.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
