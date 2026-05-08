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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lpad_student_id')->constrained('lpad_students')->cascadeOnDelete();
            $table->string('tahun_ajaran');
            $table->enum('semester', ['1', '2']);
            // Data Fisik
            $table->float('bb')->comment('Berat Badan (kg)');
            $table->float('tb')->comment('Tinggi Badan (cm)');
            $table->float('lingkar_kepala')->comment('Lingkar Kepala (cm)');
            // Kondisi Kesehatan
            $table->string('kondisi_mata');
            $table->string('kondisi_telinga');
            $table->string('kondisi_hidung');
            $table->string('kondisi_gigi');
            $table->string('kondisi_kulit');
            // Kehadiran
            $table->integer('sakit')->default(0);
            $table->integer('izin')->default(0);
            $table->integer('alpa')->default(0);
            // Komentar Orang Tua
            $table->text('komentar_ortu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
