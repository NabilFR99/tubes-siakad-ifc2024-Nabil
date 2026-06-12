@csrf
<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label class="text-sm font-medium" for="nidn">NIDN</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="nidn" name="nidn" value="{{ old('nidn', $dosen->nidn ?? '') }}" required>
        @error('nidn') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="nama">Nama</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="nama" name="nama" value="{{ old('nama', $dosen->nama ?? '') }}" required>
        @error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="email">Email</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="email" name="email" type="email" value="{{ old('email', $dosen->email ?? '') }}" required>
        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="prodi">Prodi</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="prodi" name="prodi" value="{{ old('prodi', $dosen->prodi ?? 'Teknik Informatika') }}" required>
        @error('prodi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="no_hp">No HP</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="no_hp" name="no_hp" value="{{ old('no_hp', $dosen->no_hp ?? '') }}">
        @error('no_hp') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="alamat">Alamat</label>
        <textarea class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="alamat" name="alamat" rows="3">{{ old('alamat', $dosen->alamat ?? '') }}</textarea>
        @error('alamat') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>
<div class="mt-6 flex gap-2">
    <button class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800" type="submit">Simpan</button>
    <a class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-100" href="{{ route('admin.dosens.index') }}">Batal</a>
</div>
