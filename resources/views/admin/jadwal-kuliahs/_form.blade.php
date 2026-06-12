@csrf
<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label class="text-sm font-medium" for="mata_kuliah_id">Mata Kuliah</label>
        <select class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="mata_kuliah_id" name="mata_kuliah_id" required>
            <option value="">Pilih mata kuliah</option>
            @foreach($mataKuliahs as $mataKuliah)
                <option value="{{ $mataKuliah->id }}" @selected(old('mata_kuliah_id', $jadwalKuliah->mata_kuliah_id ?? '') == $mataKuliah->id)>{{ $mataKuliah->kode }} - {{ $mataKuliah->nama }}</option>
            @endforeach
        </select>
        @error('mata_kuliah_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="dosen_id">Dosen Pengajar</label>
        <select class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="dosen_id" name="dosen_id" required>
            <option value="">Pilih dosen</option>
            @foreach($dosens as $dosen)
                <option value="{{ $dosen->id }}" @selected(old('dosen_id', $jadwalKuliah->dosen_id ?? '') == $dosen->id)>{{ $dosen->nama }}</option>
            @endforeach
        </select>
        @error('dosen_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="hari">Hari</label>
        <select class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="hari" name="hari" required>
            @foreach($hariList as $hari)
                <option value="{{ $hari }}" @selected(old('hari', $jadwalKuliah->hari ?? 'Senin') === $hari)>{{ $hari }}</option>
            @endforeach
        </select>
        @error('hari') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="kelas">Kelas</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="kelas" name="kelas" value="{{ old('kelas', $jadwalKuliah->kelas ?? 'TI-4A') }}" required>
        @error('kelas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="jam_mulai">Jam Mulai</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="jam_mulai" name="jam_mulai" type="time" value="{{ old('jam_mulai', isset($jadwalKuliah) ? substr($jadwalKuliah->jam_mulai, 0, 5) : '08:00') }}" required>
        @error('jam_mulai') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="jam_selesai">Jam Selesai</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="jam_selesai" name="jam_selesai" type="time" value="{{ old('jam_selesai', isset($jadwalKuliah) ? substr($jadwalKuliah->jam_selesai, 0, 5) : '10:30') }}" required>
        @error('jam_selesai') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="ruang">Ruang</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="ruang" name="ruang" value="{{ old('ruang', $jadwalKuliah->ruang ?? 'R.201') }}" required>
        @error('ruang') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="kuota">Kuota</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="kuota" name="kuota" type="number" min="1" value="{{ old('kuota', $jadwalKuliah->kuota ?? 35) }}" required>
        @error('kuota') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="tahun_akademik">Tahun Akademik</label>
        <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="tahun_akademik" name="tahun_akademik" value="{{ old('tahun_akademik', $jadwalKuliah->tahun_akademik ?? '2025/2026') }}" required>
        @error('tahun_akademik') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium" for="semester_akademik">Semester Akademik</label>
        <select class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2" id="semester_akademik" name="semester_akademik" required>
            @foreach(['Ganjil', 'Genap'] as $semester)
                <option value="{{ $semester }}" @selected(old('semester_akademik', $jadwalKuliah->semester_akademik ?? 'Genap') === $semester)>{{ $semester }}</option>
            @endforeach
        </select>
        @error('semester_akademik') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>
<div class="mt-6 flex gap-2">
    <button class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800" type="submit">Simpan</button>
    <a class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-100" href="{{ route('admin.jadwal-kuliahs.index') }}">Batal</a>
</div>
