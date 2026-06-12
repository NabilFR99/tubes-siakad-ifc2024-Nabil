@extends('layouts.app')

@section('content')
<div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Admin</p>
        <h2 class="text-2xl font-bold">Data Jadwal Kuliah</h2>
    </div>
    <a class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800" href="{{ route('admin.jadwal-kuliahs.create') }}">Tambah Jadwal</a>
</div>

<form class="mb-4 flex gap-2" method="GET">
    <input class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm" name="search" value="{{ $search }}" placeholder="Cari mata kuliah, dosen, hari, kelas, ruang">
    <button class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-100" type="submit">Cari</button>
</form>

<section class="rounded-lg border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="px-5 py-3">Mata Kuliah</th>
                    <th class="px-5 py-3">Dosen</th>
                    <th class="px-5 py-3">Waktu</th>
                    <th class="px-5 py-3">Kelas</th>
                    <th class="px-5 py-3">Kuota</th>
                    <th class="px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($jadwalKuliahs as $jadwalKuliah)
                    <tr>
                        <td class="px-5 py-3 font-medium">{{ $jadwalKuliah->mataKuliah->nama }}</td>
                        <td class="px-5 py-3">{{ $jadwalKuliah->dosen->nama }}</td>
                        <td class="px-5 py-3">{{ $jadwalKuliah->hari }}, {{ substr($jadwalKuliah->jam_mulai, 0, 5) }}-{{ substr($jadwalKuliah->jam_selesai, 0, 5) }}</td>
                        <td class="px-5 py-3">{{ $jadwalKuliah->kelas }} / {{ $jadwalKuliah->ruang }}</td>
                        <td class="px-5 py-3">{{ $jadwalKuliah->kuota }}</td>
                        <td class="px-5 py-3">
                            <div class="flex gap-2">
                                <a class="rounded-md border border-slate-300 px-3 py-1.5 font-semibold hover:bg-slate-100" href="{{ route('admin.jadwal-kuliahs.show', $jadwalKuliah) }}">Lihat</a>
                                <a class="rounded-md border border-slate-300 px-3 py-1.5 font-semibold hover:bg-slate-100" href="{{ route('admin.jadwal-kuliahs.edit', $jadwalKuliah) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.jadwal-kuliahs.destroy', $jadwalKuliah) }}" onsubmit="return confirm('Hapus jadwal ini?')">
                                    @csrf @method('DELETE')
                                    <button class="rounded-md border border-red-300 px-3 py-1.5 font-semibold text-red-700 hover:bg-red-50" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td class="px-5 py-4 text-slate-500" colspan="6">Data jadwal belum tersedia.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
<div class="mt-4">{{ $jadwalKuliahs->links() }}</div>
@endsection
