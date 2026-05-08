<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Membuat tabel 'documents' untuk menyimpan path file dokumen persyaratan PPDB.
 * Semua kolom file nullable karena dokumen bisa diupload bertahap (mode draft).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            // Dokumen persyaratan — nullable untuk mendukung pengisian bertahap
            $table->string('akta_kelahiran')->nullable()->comment('Path file akta kelahiran');
            $table->string('kartu_keluarga')->nullable()->comment('Path file kartu keluarga');
            $table->string('ijazah_tk')->nullable()->comment('Path file ijazah TK/PAUD sebelumnya');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
