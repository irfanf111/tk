<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('catatan_perkembangans', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel students (Siswa)
            $table->foreignId('siswa_id')
                ->constrained('students')
                ->cascadeOnDelete();
                
            // Relasi ke tabel competencies (Tujuan Pembelajaran)
            $table->foreignId('kompetensi_id')
                ->constrained('competencies')
                ->cascadeOnDelete();
                
            // Status pencapaian: Optimal / Perlu Bimbingan
            $table->enum('status_pencapaian', ['Optimal', 'Perlu Bimbingan']);
            
            // Catatan observasi guru yang bersifat khusus/personal (opsional)
            $table->text('catatan_khusus')->nullable();
            
            $table->timestamps();

            // Mencegah duplikasi data: satu anak hanya memiliki satu catatan per TP
            $table->unique(['siswa_id', 'kompetensi_id'], 'siswa_kompetensi_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_perkembangans');
    }
};
