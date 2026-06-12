<?php

namespace Tests\Feature;

use App\Models\Dosen;
use App\Models\JadwalKuliah;
use App\Models\Krs;
use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KrsApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_dashboard_and_master_data(): void
    {
        $this->seed();

        $admin = User::where('role', 'admin')->firstOrFail();

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Rekap Akademik FT UNSUR');

        $this->actingAs($admin)
            ->get(route('admin.dosens.index'))
            ->assertOk()
            ->assertSee('Data Dosen');
    }

    public function test_mahasiswa_can_take_and_drop_krs(): void
    {
        $this->seed();

        $user = User::where('role', 'mahasiswa')->firstOrFail();
        $mahasiswa = $user->mahasiswa;
        $jadwal = JadwalKuliah::whereDoesntHave('krs', fn ($query) => $query->where('mahasiswa_id', $mahasiswa->id))->firstOrFail();

        $this->actingAs($user)
            ->get(route('krs.index'))
            ->assertOk()
            ->assertSee('Input KRS');

        $this->actingAs($user)
            ->post(route('krs.store'), ['jadwal_kuliah_id' => $jadwal->id])
            ->assertRedirect(route('krs.index'));

        $this->assertDatabaseHas('krs', [
            'mahasiswa_id' => $mahasiswa->id,
            'jadwal_kuliah_id' => $jadwal->id,
        ]);

        $krs = Krs::where('mahasiswa_id', $mahasiswa->id)
            ->where('jadwal_kuliah_id', $jadwal->id)
            ->firstOrFail();

        $this->actingAs($user)
            ->delete(route('krs.destroy', $krs))
            ->assertRedirect(route('krs.index'));

        $this->assertDatabaseMissing('krs', [
            'id' => $krs->id,
        ]);
    }

    public function test_taken_course_is_not_offered_again_when_searching_available_schedules(): void
    {
        $this->seed();

        $user = User::where('role', 'mahasiswa')->firstOrFail();
        $takenKrs = $user->mahasiswa->krs()->with('jadwalKuliah.mataKuliah')->firstOrFail();

        $this->actingAs($user)
            ->get(route('krs.index', ['search' => $takenKrs->jadwalKuliah->mataKuliah->nama]))
            ->assertOk()
            ->assertDontSee('value="'.$takenKrs->jadwal_kuliah_id.'"', false);
    }

    public function test_mahasiswa_cannot_take_same_course_from_another_schedule(): void
    {
        $this->seed();

        $user = User::where('role', 'mahasiswa')->firstOrFail();
        $takenJadwal = $user->mahasiswa->krs()->with('jadwalKuliah')->firstOrFail()->jadwalKuliah;
        $alternateJadwal = JadwalKuliah::create([
            'mata_kuliah_id' => $takenJadwal->mata_kuliah_id,
            'dosen_id' => $takenJadwal->dosen_id,
            'hari' => 'Jumat',
            'jam_mulai' => '15:00',
            'jam_selesai' => '17:00',
            'kelas' => 'TI-4B',
            'ruang' => 'R.205',
            'kuota' => 35,
            'tahun_akademik' => $takenJadwal->tahun_akademik,
            'semester_akademik' => $takenJadwal->semester_akademik,
        ]);

        $this->actingAs($user)
            ->post(route('krs.store'), ['jadwal_kuliah_id' => $alternateJadwal->id])
            ->assertSessionHasErrors('jadwal_kuliah_id');

        $this->assertDatabaseMissing('krs', [
            'mahasiswa_id' => $user->mahasiswa->id,
            'jadwal_kuliah_id' => $alternateJadwal->id,
        ]);
    }

    public function test_mahasiswa_cannot_take_conflicting_schedule(): void
    {
        $this->seed();

        $user = User::where('role', 'mahasiswa')->firstOrFail();
        $takenJadwal = $user->mahasiswa->krs()->with('jadwalKuliah')->firstOrFail()->jadwalKuliah;
        $mataKuliah = MataKuliah::create([
            'kode' => 'IF99901',
            'nama' => 'Keamanan Aplikasi',
            'sks' => 3,
            'semester' => 4,
            'prodi' => 'Teknik Informatika',
        ]);

        $conflictingJadwal = JadwalKuliah::create([
            'mata_kuliah_id' => $mataKuliah->id,
            'dosen_id' => Dosen::firstOrFail()->id,
            'hari' => $takenJadwal->hari,
            'jam_mulai' => $takenJadwal->jam_mulai,
            'jam_selesai' => $takenJadwal->jam_selesai,
            'kelas' => 'TI-4B',
            'ruang' => 'Lab RPL',
            'kuota' => 35,
            'tahun_akademik' => $takenJadwal->tahun_akademik,
            'semester_akademik' => $takenJadwal->semester_akademik,
        ]);

        $this->actingAs($user)
            ->post(route('krs.store'), ['jadwal_kuliah_id' => $conflictingJadwal->id])
            ->assertSessionHasErrors('jadwal_kuliah_id');

        $this->assertDatabaseMissing('krs', [
            'mahasiswa_id' => $user->mahasiswa->id,
            'jadwal_kuliah_id' => $conflictingJadwal->id,
        ]);
    }

    public function test_admin_cannot_create_duplicate_schedule_for_same_course_class_and_term(): void
    {
        $this->seed();

        $admin = User::where('role', 'admin')->firstOrFail();
        $jadwal = JadwalKuliah::firstOrFail();

        $this->actingAs($admin)
            ->post(route('admin.jadwal-kuliahs.store'), [
                'mata_kuliah_id' => $jadwal->mata_kuliah_id,
                'dosen_id' => $jadwal->dosen_id,
                'hari' => 'Jumat',
                'jam_mulai' => '15:00',
                'jam_selesai' => '17:00',
                'kelas' => $jadwal->kelas,
                'ruang' => 'R.999',
                'kuota' => 35,
                'tahun_akademik' => $jadwal->tahun_akademik,
                'semester_akademik' => $jadwal->semester_akademik,
            ])
            ->assertSessionHasErrors('semester_akademik');
    }
}
