<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Membuat tabel spp_payments untuk modul pembayaran SPP.
 * Sistem manual (bukan payment gateway) — admin input satu per satu.
 * Unique constraint [student_id, bulan] mencegah duplikasi pembayaran.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spp_payments', function (Blueprint $table) {
            $table->id();

            // Relasi ke siswa
            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            // Bulan pembayaran — format 'YYYY-MM', misal '2026-07'
            $table->string('bulan', 7)->comment("Format YYYY-MM, misal '2026-07'");

            // Nominal SPP dalam rupiah
            $table->unsignedBigInteger('nominal')->comment('Nominal SPP dalam Rupiah');

            // Tanggal pembayaran dilakukan
            $table->date('tanggal_bayar')->nullable();

            // Status pembayaran
            $table->enum('status', ['lunas', 'belum'])->default('belum');

            // Keterangan opsional (misal: terlambat, cicil, dll)
            $table->text('keterangan')->nullable();

            // Admin yang menginput / mencatat pembayaran ini
            $table->foreignId('dicatat_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            // Cegah duplikasi: satu siswa satu pembayaran per bulan
            $table->unique(['student_id', 'bulan'], 'spp_student_bulan_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spp_payments');
    }
};
