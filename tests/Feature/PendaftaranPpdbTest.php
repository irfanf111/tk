<?php

namespace Tests\Feature;

use App\Models\PpdbRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pengujian fitur Pendaftaran PPDB Daring (tanpa login).
 * Menggunakan PpdbController (bukan portal PPDB yang butuh login).
 */
class PendaftaranPpdbTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data pendaftaran PPDB yang valid dan lengkap.
     */
    private function dataValidPpdb(array $overrides = []): array
    {
        return array_merge([
            'nama_siswa'          => 'Ahmad Fauzi',
            'nik'                 => '3201234567890123',
            'nama_panggilan'      => 'Fauzi',
            'jenis_kelamin'       => 'L',
            'tempat_lahir'        => 'Bandung',
            'tanggal_lahir'       => '2021-05-10',
            'agama'               => 'Islam',
            'kewarganegaraan'     => 'WNI',
            'anak_ke'             => 1,
            'jml_saudara_kandung' => 0,
            'bahasa_sehari_hari'  => 'Indonesia',
            'berat_badan'         => 15,
            'tinggi_badan'        => 100,
            'alamat'              => 'Jl. Merdeka No. 1',
            'no_hp'               => '081234567890',
            'tinggal_bersama'     => 'Orang Tua',
        ], $overrides);
    }

    /** @test */
    public function test_pendaftaran_ppdb_berhasil_dengan_data_valid()
    {
        $response = $this->post(route('ppdb.store'), $this->dataValidPpdb());

        // Harus menyimpan ke database
        $this->assertDatabaseHas('ppdb_registrations', [
            'nama_siswa'    => 'Ahmad Fauzi',
            'nik'           => '3201234567890123',
            'jenis_kelamin' => 'L',
            'status'        => 'pending',
        ]);

        // Harus redirect ke halaman sukses
        $registrasi = PpdbRegistration::where('nik', '3201234567890123')->first();
        $response->assertRedirect(route('ppdb.success', $registrasi->id));
    }

    /** @test */
    public function test_nomor_pendaftaran_digenerate_otomatis_saat_daftar()
    {
        $this->post(route('ppdb.store'), $this->dataValidPpdb());

        $registrasi = PpdbRegistration::where('nik', '3201234567890123')->first();

        $this->assertNotNull($registrasi->nomor_pendaftaran);
        $this->assertStringStartsWith('PPDB-', $registrasi->nomor_pendaftaran);
    }

    /** @test */
    public function test_pendaftaran_ppdb_gagal_jika_nik_sudah_terdaftar()
    {
        // Daftar pertama kali
        $this->post(route('ppdb.store'), $this->dataValidPpdb());

        // Coba daftar lagi dengan NIK yang sama
        $response = $this->post(route('ppdb.store'), $this->dataValidPpdb([
            'nama_siswa' => 'Nama Berbeda',
        ]));

        $response->assertSessionHasErrors(['nik']);

        // Pastikan hanya ada 1 record dengan NIK tersebut
        $this->assertEquals(1, PpdbRegistration::where('nik', '3201234567890123')->count());
    }

    /** @test */
    public function test_pendaftaran_ppdb_gagal_jika_field_wajib_kosong()
    {
        $response = $this->post(route('ppdb.store'), [
            'nama_siswa' => '', // field wajib dikosongkan
        ]);

        $response->assertSessionHasErrors([
            'nama_siswa',
            'nik',
            'jenis_kelamin',
            'tanggal_lahir',
            'agama',
            'bahasa_sehari_hari',
            'berat_badan',
            'tinggi_badan',
            'alamat',
            'no_hp',
            'tinggal_bersama',
        ]);

        $this->assertEquals(0, PpdbRegistration::count());
    }

    /** @test */
    public function test_pendaftaran_ppdb_gagal_jika_nik_tidak_16_digit()
    {
        $response = $this->post(route('ppdb.store'), $this->dataValidPpdb([
            'nik' => '123', // NIK tidak valid (< 16 digit)
        ]));

        $response->assertSessionHasErrors(['nik']);
        $this->assertEquals(0, PpdbRegistration::count());
    }

    /** @test */
    public function test_pendaftaran_ppdb_gagal_jika_jenis_kelamin_tidak_valid()
    {
        $response = $this->post(route('ppdb.store'), $this->dataValidPpdb([
            'jenis_kelamin' => 'X', // Bukan L atau P
        ]));

        $response->assertSessionHasErrors(['jenis_kelamin']);
        $this->assertEquals(0, PpdbRegistration::count());
    }

    /** @test */
    public function test_halaman_sukses_menampilkan_nomor_pendaftaran()
    {
        $registrasi = PpdbRegistration::create([
            'nomor_pendaftaran' => 'PPDB-20261001-TEST',
            'no_pendaftaran'    => 'PPDB-20261001-TEST',
            'nama_siswa'        => 'Test Siswa',
            'nama_lengkap'      => 'Test Siswa',
            'jenis_kelamin'     => 'L',
            'tempat_lahir'      => 'Bandung',
            'tanggal_lahir'     => '2021-01-01',
            'nik'               => '9999888877776666',
            'alamat_jalan'      => 'Jl. Test',
            'status'            => 'pending',
        ]);

        $response = $this->get(route('ppdb.success', $registrasi->id));
        $response->assertStatus(200);
    }
}
