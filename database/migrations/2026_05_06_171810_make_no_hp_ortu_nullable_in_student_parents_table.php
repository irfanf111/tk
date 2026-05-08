<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jadikan no_hp_ortu nullable.
     * Kolom ini warisan sistem lama — di sistem baru, nomor HP sudah
     * disimpan di tabel students.no_hp sehingga kolom ini tidak wajib diisi.
     */
    public function up(): void
    {
        Schema::table('student_parents', function (Blueprint $table) {
            $table->string('no_hp_ortu')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('student_parents', function (Blueprint $table) {
            $table->string('no_hp_ortu')->nullable(false)->change();
        });
    }
};
