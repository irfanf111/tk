<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jadikan kolom-kolom lama (sistem lama) nullable agar tidak memblokir
     * pendaftaran PPDB baru yang tidak mengisi field-field tersebut.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Kolom lama dari sistem sebelumnya — tidak wajib diisi oleh pendaftar baru
            $table->string('nis')->nullable()->change();
            $table->unsignedBigInteger('ppdb_registration_id')->nullable()->change();
            $table->unsignedBigInteger('classroom_id')->nullable()->change();
            $table->string('status')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('nis')->nullable(false)->change();
            $table->unsignedBigInteger('classroom_id')->nullable(false)->change();
            $table->string('status')->nullable(false)->change();
        });
    }
};
