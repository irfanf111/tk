<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pengujian fitur Manajemen Data Siswa.
 * Catatan: CRUD siswa dikelola via Filament Admin Panel (bukan controller HTTP biasa).
 * Test ini memverifikasi logika model, relasi, factory, dan constraint DB secara langsung,
 * karena pengujian Filament membutuhkan setup Livewire yang di luar cakupan KP ini.
 */
class ManajemenSiswaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_siswa_berhasil_ditambahkan_ke_database()
    {
        $student = Student::factory()->create([
            'nama_lengkap' => 'Siti Rahayu',
            'nis'          => 'S001',
        ]);

        $this->assertDatabaseHas('students', [
            'nama_lengkap' => 'Siti Rahayu',
            'nis'          => 'S001',
        ]);
    }

    /** @test */
    public function test_siswa_gagal_ditambahkan_jika_nis_sudah_ada()
    {
        Student::factory()->create(['nis' => 'S001']);

        // Coba buat siswa lain dengan NIS yang sama — harus melempar exception
        $this->expectException(\Illuminate\Database\QueryException::class);

        Student::factory()->create(['nis' => 'S001']);
    }

    /** @test */
    public function test_data_siswa_dapat_diperbarui()
    {
        $student = Student::factory()->create([
            'nama_lengkap' => 'Nama Lama',
        ]);

        $student->update(['nama_lengkap' => 'Nama Baru']);

        $this->assertDatabaseHas('students', ['nama_lengkap' => 'Nama Baru']);
        $this->assertDatabaseMissing('students', ['nama_lengkap' => 'Nama Lama']);
    }

    /** @test */
    public function test_data_siswa_dapat_dihapus_dari_database()
    {
        $student = Student::factory()->create();

        $student->delete();

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    /** @test */
    public function test_display_name_accessor_mengembalikan_nama_lengkap()
    {
        $student = Student::factory()->create([
            'nama_lengkap'  => 'Budi Santoso',
            'nama_panggilan' => 'Budi',
        ]);

        $this->assertEquals('Budi Santoso', $student->display_name);
    }

    /** @test */
    public function test_display_name_accessor_fallback_ke_nama_panggilan_jika_nama_lengkap_kosong()
    {
        $student = Student::factory()->create([
            'nama_lengkap'  => null,
            'nama_panggilan' => 'Rini',
        ]);

        $this->assertEquals('Rini', $student->display_name);
    }

    /** @test */
    public function test_relasi_siswa_ke_pembayaran_spp_berfungsi()
    {
        $student = Student::factory()->create();

        // Buat 2 data SPP untuk siswa ini
        \App\Models\SppPayment::create([
            'student_id' => $student->id,
            'bulan'      => '2026-07',
            'nominal'    => 150000,
            'status'     => 'lunas',
        ]);

        \App\Models\SppPayment::create([
            'student_id' => $student->id,
            'bulan'      => '2026-08',
            'nominal'    => 150000,
            'status'     => 'belum',
        ]);

        $this->assertCount(2, $student->sppPayments);
    }

    /** @test */
    public function test_siswa_memiliki_jenis_kelamin_yang_valid()
    {
        $siswaL = Student::factory()->create(['jenis_kelamin' => 'L']);
        $siswaP = Student::factory()->create(['jenis_kelamin' => 'P']);

        $this->assertEquals('L', $siswaL->jenis_kelamin);
        $this->assertEquals('P', $siswaP->jenis_kelamin);
    }
}
