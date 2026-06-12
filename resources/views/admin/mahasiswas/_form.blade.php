@csrf
<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label class="text-sm font-medium" for="nim">NIM</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim ?? '') }}" required>
        @error('nim') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="nama">Nama</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="nama" name="nama" value="{{ old('nama', $mahasiswa->nama ?? '') }}" required>
        @error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="email">Email Login</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="email" name="email" type="email" value="{{ old('email', $mahasiswa->user->email ?? '') }}" required>
        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="password">Password {{ isset($mahasiswa) ? '(kosongkan jika tidak diubah)' : '' }}</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="password" name="password" type="password" {{ isset($mahasiswa) ? '' : 'required' }}>
        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="prodi">Prodi</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="prodi" name="prodi" value="{{ old('prodi', $mahasiswa->prodi ?? 'Teknik Informatika') }}" required>
        @error('prodi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="angkatan">Angkatan</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="angkatan" name="angkatan" type="number" value="{{ old('angkatan', $mahasiswa->angkatan ?? date('Y')) }}" required>
        @error('angkatan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="kelas">Kelas</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="kelas" name="kelas" value="{{ old('kelas', $mahasiswa->kelas ?? 'TI-4A') }}" required>
        @error('kelas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="no_hp">No HP</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="no_hp" name="no_hp" value="{{ old('no_hp', $mahasiswa->no_hp ?? '') }}">
        @error('no_hp') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div class="sm:col-span-2">
        <label class="text-sm font-medium" for="alamat">Alamat</label>
        <textarea class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="alamat" name="alamat" rows="3">{{ old('alamat', $mahasiswa->alamat ?? '') }}</textarea>
        @error('alamat') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>
<div class="mt-6 flex gap-2">
    <button class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800" type="submit">Simpan</button>
    <a class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-100" href="{{ route('admin.mahasiswas.index') }}">Batal</a>
</div>
