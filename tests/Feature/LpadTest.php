<?php

namespace Tests\Feature;

use App\Models\LpadStudent;
use App\Models\Report;
use App\Models\ReportNarrative;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pengujian fitur LPAD (Laporan Perkembangan Anak Didik).
 * Jalur: GET lpad/buat (form), POST lpad/simpan (store).
 */
class LpadTest extends TestCase
{
    use RefreshDatabase;

    private function dataLpadValid(int $lpadStudentId): array
    {
        return [
            'lpad_student_id'           => $lpadStudentId,
            'tahun_ajaran'              => '2026/2027',
            'semester'                  => '1',
            'bb'                        => 15.5,
            'tb'                        => 100.0,
            'lingkar_kepala'            => 50.0,
            'kondisi_mata'              => 'Normal',
            'kondisi_telinga'           => 'Normal',
            'kondisi_hidung'            => 'Normal',
            'kondisi_gigi'              => 'Normal',
            'kondisi_kulit'             => 'Normal',
            'sakit'                     => 0,
            'izin'                      => 1,
            'alpa'                      => 0,
            'komentar_ortu'             => 'Anak berkembang dengan baik.',
            'elemen_agama_budi_pekerti' => 'Berkembang Sesuai Harapan',
            'elemen_jati_diri'          => 'Berkembang Sesuai Harapan',
            'elemen_literasi_steam'     => 'Berkembang Sesuai Harapan',
            'projek_p5'                 => 'Baik',
        ];
    }

    /** @test */
    public function test_halaman_form_lpad_dapat_diakses_tanpa_login()
    {
        $response = $this->get(route('reports.create'));
        $response->assertStatus(200);
    }

    /** @test */
    public function test_input_lpad_berhasil_disimpan_ke_database()
    {
        $siswa = LpadStudent::factory()->create();

        $response = $this->post(route('reports.store'), $this->dataLpadValid($siswa->id));

        $response->assertRedirect(route('reports.create'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('reports', [
            'lpad_student_id' => $siswa->id,
            'tahun_ajaran'    => '2026/2027',
            'semester'        => '1',
        ]);

        // Narasi juga tersimpan
        $report = Report::where('lpad_student_id', $siswa->id)->first();
        $this->assertDatabaseHas('report_narratives', [
            'report_id'                 => $report->id,
            'elemen_agama_budi_pekerti' => 'Berkembang Sesuai Harapan',
        ]);
    }

    /** @test */
    public function test_input_lpad_gagal_jika_siswa_tidak_ditemukan()
    {
        $response = $this->post(route('reports.store'), $this->dataLpadValid(999));

        $response->assertSessionHasErrors(['lpad_student_id']);
        $this->assertEquals(0, Report::count());
    }

    /** @test */
    public function test_input_lpad_gagal_jika_semester_tidak_valid()
    {
        $siswa = LpadStudent::factory()->create();

        $data              = $this->dataLpadValid($siswa->id);
        $data['semester']  = '3'; // Hanya boleh 1 atau 2

        $response = $this->post(route('reports.store'), $data);

        $response->assertSessionHasErrors(['semester']);
        $this->assertEquals(0, Report::count());
    }

    /** @test */
    public function test_input_lpad_gagal_jika_field_wajib_kosong()
    {
        $response = $this->post(route('reports.store'), []);

        $response->assertSessionHasErrors([
            'lpad_student_id',
            'tahun_ajaran',
            'semester',
            'bb',
            'tb',
            'lingkar_kepala',
        ]);
    }

    /** @test */
    public function test_laporan_baru_dengan_no_induk_yang_sudah_ada_tetap_tersimpan()
    {
        // Siswa yang sama bisa punya banyak laporan (beda semester/tahun)
        $siswa = LpadStudent::factory()->create();

        // Simpan laporan semester 1
        $this->post(route('reports.store'), $this->dataLpadValid($siswa->id));

        // Simpan laporan semester 2 untuk siswa yang sama
        $data             = $this->dataLpadValid($siswa->id);
        $data['semester'] = '2';

        $this->post(route('reports.store'), $data);

        $this->assertEquals(2, Report::where('lpad_student_id', $siswa->id)->count());
    }
}
