<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Membuat tabel 'registrations' sebagai pusat status pendaftaran PPDB.
 * Tabel ini terpisah dari 'ppdb_registrations' (sistem lama) dan menjadi
 * patokan status resmi pendaftaran dalam alur PPDB yang baru.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            // Status alur pendaftaran PPDB
            $table->enum('status', [
                'draft',        // Sedang mengisi formulir
                'submitted',    // Formulir sudah dikirim, menunggu verifikasi
                'verified',     // Data sudah diverifikasi admin
                'rejected',     // Ditolak karena syarat tidak lengkap / tidak memenuhi
                'accepted',     // Diterima sebagai peserta didik baru
                'not_accepted', // Tidak diterima (kuota penuh, dsb.)
            ])->default('draft');

            // Catatan dari admin (diisi saat rejected/not_accepted atau pemberitahuan khusus)
            $table->text('notes')->nullable();

            // Siapa admin yang memverifikasi
            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Kapan verifikasi dilakukan
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
