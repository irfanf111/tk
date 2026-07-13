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
        Schema::create('tagihan_spps', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel students (Siswa)
            $table->foreignId('siswa_id')
                ->constrained('students')
                ->cascadeOnDelete();
                
            $table->string('bulan_tagihan', 7)->comment("Format YYYY-MM");
            $table->unsignedInteger('total_tagihan')->default(45000);
            $table->date('tenggat_pembayaran');
            $table->string('status', 20)->default('Belum Lunas'); // Lunas / Belum Lunas
            $table->date('tanggal_pembayaran')->nullable();
            
            $table->timestamps();

            // Mencegah duplikasi tagihan untuk siswa yang sama pada bulan yang sama
            $table->unique(['siswa_id', 'bulan_tagihan'], 'siswa_bulan_tagihan_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_spps');
    }
};
