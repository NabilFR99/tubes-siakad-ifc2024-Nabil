@extends('layouts.app')

@section('content')
<div class="mb-6">
    <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Dashboard Admin</p>
    <h2 class="mt-1 text-2xl font-bold">Rekap Akademik FT UNSUR</h2>
</div>

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
    @foreach([
        'Mahasiswa' => $totalMahasiswa,
        'Dosen' => $totalDosen,
        'Mata Kuliah' => $totalMataKuliah,
        'Jadwal' => $totalJadwal,
        'KRS' => $totalKrs,
    ] as $label => $value)
        <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">{{ $label }}</p>
            <p class="mt-2 text-3xl font-bold">{{ $value }}</p>
        </section>
    @endforeach
</div>

<section class="mt-6 rounded-lg border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 px-5 py-4">
        <h3 class="font-semibold">KRS Terbaru</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="px-5 py-3">Mahasiswa</th>
                    <th class="px-5 py-3">Mata Kuliah</th>
                    <th class="px-5 py-3">Semester</th>
                    <th class="px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($latestKrs as $item)
                    <tr>
                        <td class="px-5 py-3">{{ $item->mahasiswa->nama }}</td>
                        <td class="px-5 py-3">{{ $item->jadwalKuliah->mataKuliah->nama }}</td>
                        <td class="px-5 py-3">{{ $item->semester }} {{ $item->tahun_akademik }}</td>
                        <td class="px-5 py-3">{{ ucfirst($item->status) }}</td>
                    </tr>
                @empty
                    <tr><td class="px-5 py-4 text-slate-500" colspan="4">Belum ada data KRS.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
