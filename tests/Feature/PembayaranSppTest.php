<?php

namespace Tests\Feature;

use App\Models\SppPayment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pengujian fitur Pembayaran SPP.
 * SPP dikelola via Filament (admin panel), sehingga pengujian
 * difokuskan pada model, constraint database, dan relasi.
 */
class PembayaranSppTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_pembayaran_spp_dapat_disimpan_ke_database()
    {
        $admin   = User::factory()->create(['role' => 'admin']);
        $student = Student::factory()->create();

        $payment = SppPayment::create([
            'student_id'    => $student->id,
            'bulan'         => '2026-07',
            'nominal'       => 150000,
            'tanggal_bayar' => '2026-07-05',
            'status'        => 'lunas',
            'dicatat_oleh'  => $admin->id,
        ]);

        $this->assertDatabaseHas('spp_payments', [
            'student_id' => $student->id,
            'bulan'      => '2026-07',
            'nominal'    => 150000,
            'status'     => 'lunas',
        ]);
    }

    /** @test */
    public function test_tidak_bisa_ada_dua_pembayaran_spp_untuk_bulan_yang_sama()
    {
        $student = Student::factory()->create();

        SppPayment::create([
            'student_id'    => $student->id,
            'bulan'         => '2026-07',
            'nominal'       => 150000,
            'tanggal_bayar' => '2026-07-05',
            'status'        => 'lunas',
        ]);

        // Mencoba memasukkan duplikasi — harus melempar exception DB
        $this->expectException(\Illuminate\Database\QueryException::class);

        SppPayment::create([
            'student_id'    => $student->id,
            'bulan'         => '2026-07', // bulan yang sama!
            'nominal'       => 150000,
            'tanggal_bayar' => '2026-07-10',
            'status'        => 'lunas',
        ]);
    }

    /** @test */
    public function test_pembayaran_spp_berbeda_bulan_untuk_siswa_yang_sama_diizinkan()
    {
        $student = Student::factory()->create();

        SppPayment::create([
            'student_id'    => $student->id,
            'bulan'         => '2026-07',
            'nominal'       => 150000,
            'tanggal_bayar' => '2026-07-05',
            'status'        => 'lunas',
        ]);

        SppPayment::create([
            'student_id'    => $student->id,
            'bulan'         => '2026-08', // bulan berbeda
            'nominal'       => 150000,
            'tanggal_bayar' => '2026-08-05',
            'status'        => 'lunas',
        ]);

        $this->assertEquals(2, SppPayment::where('student_id', $student->id)->count());
    }

    /** @test */
    public function test_scope_lunas_hanya_mengembalikan_pembayaran_lunas()
    {
        $student = Student::factory()->create();

        SppPayment::create([
            'student_id'    => $student->id,
            'bulan'         => '2026-07',
            'nominal'       => 150000,
            'status'        => 'lunas',
        ]);

        SppPayment::create([
            'student_id'    => $student->id,
            'bulan'         => '2026-08',
            'nominal'       => 150000,
            'status'        => 'belum',
        ]);

        $lunas = SppPayment::lunas()->get();

        $this->assertCount(1, $lunas);
        $this->assertEquals('lunas', $lunas->first()->status);
    }

    /** @test */
    public function test_accessor_bulan_label_mengembalikan_format_yang_benar()
    {
        $student = Student::factory()->create();

        $payment = SppPayment::create([
            'student_id'    => $student->id,
            'bulan'         => '2026-07',
            'nominal'       => 150000,
            'status'        => 'lunas',
        ]);

        // Accessor getBulanLabelAttribute harus mengembalikan format bulan lokal
        $this->assertNotEmpty($payment->bulan_label);
        $this->assertStringContainsString('2026', $payment->bulan_label);
    }

    /** @test */
    public function test_accessor_nominal_format_mengembalikan_format_rupiah()
    {
        $student = Student::factory()->create();

        $payment = SppPayment::create([
            'student_id'    => $student->id,
            'bulan'         => '2026-09',
            'nominal'       => 150000,
            'status'        => 'lunas',
        ]);

        $this->assertStringStartsWith('Rp', $payment->nominal_format);
        $this->assertStringContainsString('150', $payment->nominal_format);
    }

    /** @test */
    public function test_relasi_pembayaran_spp_ke_student_berjalan_benar()
    {
        $student = Student::factory()->create(['nama_lengkap' => 'Siswa Satu']);

        $payment = SppPayment::create([
            'student_id'    => $student->id,
            'bulan'         => '2026-10',
            'nominal'       => 200000,
            'status'        => 'lunas',
        ]);

        $this->assertEquals('Siswa Satu', $payment->student->nama_lengkap);
    }
}
