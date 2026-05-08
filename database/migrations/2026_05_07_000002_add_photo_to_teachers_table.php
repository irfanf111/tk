<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom 'photo' (path file upload) ke tabel teachers.
     * Kolom 'foto' lama (URL teks) tetap dipertahankan agar data lama tidak hilang.
     */
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            // Kolom baru: menyimpan path hasil FileUpload Filament
            $table->string('photo')->nullable()->after('foto');
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }
};
