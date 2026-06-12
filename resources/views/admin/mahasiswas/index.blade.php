@extends('layouts.app')

@section('content')
<div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Admin</p>
        <h2 class="text-2xl font-bold">Data Mahasiswa</h2>
    </div>
    <a class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800" href="{{ route('admin.mahasiswas.create') }}">Tambah Mahasiswa</a>
</div>

<form class="mb-4 flex gap-2" method="GET">
    <input class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm" name="search" value="{{ $search }}" placeholder="Cari NIM, nama, prodi, kelas">
    <button class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-100" type="submit">Cari</button>
</form>

<section class="rounded-lg border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="px-5 py-3">NIM</th>
                    <th class="px-5 py-3">Nama</th>
                    <th class="px-5 py-3">Email</th>
                    <th class="px-5 py-3">Kelas</th>
                    <th class="px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($mahasiswas as $mahasiswa)
                    <tr>
                        <td class="px-5 py-3">{{ $mahasiswa->nim }}</td>
                        <td class="px-5 py-3 font-medium">{{ $mahasiswa->nama }}</td>
                        <td class="px-5 py-3">{{ $mahasiswa->user->email }}</td>
                        <td class="px-5 py-3">{{ $mahasiswa->kelas }}</td>
                        <td class="px-5 py-3">
                            <div class="flex gap-2">
                                <a class="rounded-md border border-slate-300 px-3 py-1.5 font-semibold hover:bg-slate-100" href="{{ route('admin.mahasiswas.show', $mahasiswa) }}">Lihat</a>
                                <a class="rounded-md border border-slate-300 px-3 py-1.5 font-semibold hover:bg-slate-100" href="{{ route('admin.mahasiswas.edit', $mahasiswa) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.mahasiswas.destroy', $mahasiswa) }}" onsubmit="return confirm('Hapus mahasiswa dan akun loginnya?')">
                                    @csrf @method('DELETE')
                                    <button class="rounded-md border border-red-300 px-3 py-1.5 font-semibold text-red-700 hover:bg-red-50" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td class="px-5 py-4 text-slate-500" colspan="5">Data mahasiswa belum tersedia.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
<div class="mt-4">{{ $mahasiswas->links() }}</div>
@endsection
