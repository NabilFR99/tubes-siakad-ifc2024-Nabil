@csrf
<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label class="text-sm font-medium" for="kode">Kode</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="kode" name="kode" value="{{ old('kode', $mataKuliah->kode ?? '') }}" required>
        @error('kode') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="nama">Nama Mata Kuliah</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="nama" name="nama" value="{{ old('nama', $mataKuliah->nama ?? '') }}" required>
        @error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="sks">SKS</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="sks" name="sks" type="number" min="1" max="6" value="{{ old('sks', $mataKuliah->sks ?? 3) }}" required>
        @error('sks') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="semester">Semester</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="semester" name="semester" type="number" min="1" max="14" value="{{ old('semester', $mataKuliah->semester ?? 4) }}" required>
        @error('semester') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="prodi">Prodi</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="prodi" name="prodi" value="{{ old('prodi', $mataKuliah->prodi ?? 'Teknik Informatika') }}" required>
        @error('prodi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="deskripsi">Deskripsi</label>
        <textarea class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $mataKuliah->deskripsi ?? '') }}</textarea>
        @error('deskripsi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>
<div class="mt-6 flex gap-2">
    <button class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800" type="submit">Simpan</button>
    <a class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-100" href="{{ route('admin.mata-kuliahs.index') }}">Batal</a>
</div>
