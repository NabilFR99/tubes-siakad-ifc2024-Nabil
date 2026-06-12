<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\JadwalKuliah;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin FT UNSUR',
            'email' => 'admin@ftunsur.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $mahasiswaUser = User::create([
            'name' => 'Nabil Firmansyah',
            'email' => 'nabil@ftunsur.test',
            'password' => 'password',
            'role' => 'mahasiswa',
        ]);

        $mahasiswa = Mahasiswa::create([
            'user_id' => $mahasiswaUser->id,
            'nim' => '2023001001',
            'nama' => 'Nabil Firmansyah',
            'prodi' => 'Teknik Informatika',
            'angkatan' => 2023,
            'kelas' => 'TI-4A',
            'no_hp' => '081234567890',
            'alamat' => 'Cianjur',
        ]);

        $dosens = collect([
            ['nidn' => '0401019001', 'nama' => 'Dr. Asep Hidayat, M.Kom.', 'email' => 'asep@ftunsur.test', 'prodi' => 'Teknik Informatika'],
            ['nidn' => '0402029102', 'nama' => 'Rina Marlina, S.T., M.T.', 'email' => 'rina@ftunsur.test', 'prodi' => 'Sistem Informasi'],
            ['nidn' => '0403039203', 'nama' => 'Dedi Kurniawan, M.Kom.', 'email' => 'dedi@ftunsur.test', 'prodi' => 'Teknik Informatika'],
        ])->map(fn (array $data) => Dosen::create($data));

        $mataKuliahs = collect([
            ['kode' => 'IF53413', 'nama' => 'Pemrograman Web II', 'sks' => 3, 'semester' => 4, 'prodi' => 'Teknik Informatika'],
            ['kode' => 'IF53221', 'nama' => 'Basis Data Lanjut', 'sks' => 3, 'semester' => 4, 'prodi' => 'Teknik Informatika'],
            ['kode' => 'IF53109', 'nama' => 'Rekayasa Perangkat Lunak', 'sks' => 3, 'semester' => 4, 'prodi' => 'Teknik Informatika'],
            ['kode' => 'IF53007', 'nama' => 'Jaringan Komputer', 'sks' => 2, 'semester' => 4, 'prodi' => 'Teknik Informatika'],
        ])->map(fn (array $data) => MataKuliah::create($data));

        $jadwal = collect([
            ['mata_kuliah_id' => $mataKuliahs[0]->id, 'dosen_id' => $dosens[0]->id, 'hari' => 'Senin', 'jam_mulai' => '08:00', 'jam_selesai' => '10:30', 'kelas' => 'TI-4A', 'ruang' => 'Lab Web', 'kuota' => 35],
            ['mata_kuliah_id' => $mataKuliahs[1]->id, 'dosen_id' => $dosens[2]->id, 'hari' => 'Selasa', 'jam_mulai' => '10:30', 'jam_selesai' => '13:00', 'kelas' => 'TI-4A', 'ruang' => 'R.204', 'kuota' => 35],
            ['mata_kuliah_id' => $mataKuliahs[2]->id, 'dosen_id' => $dosens[1]->id, 'hari' => 'Rabu', 'jam_mulai' => '08:00', 'jam_selesai' => '10:30', 'kelas' => 'TI-4A', 'ruang' => 'R.201', 'kuota' => 35],
            ['mata_kuliah_id' => $mataKuliahs[3]->id, 'dosen_id' => $dosens[2]->id, 'hari' => 'Kamis', 'jam_mulai' => '13:00', 'jam_selesai' => '14:40', 'kelas' => 'TI-4A', 'ruang' => 'Lab Jaringan', 'kuota' => 30],
        ])->map(fn (array $data) => JadwalKuliah::create($data + [
            'tahun_akademik' => '2025/2026',
            'semester_akademik' => 'Genap',
        ]));

        Krs::create([
            'mahasiswa_id' => $mahasiswa->id,
            'jadwal_kuliah_id' => $jadwal[0]->id,
            'tahun_akademik' => '2025/2026',
            'semester' => 'Genap',
            'status' => 'diambil',
        ]);
    }
}
