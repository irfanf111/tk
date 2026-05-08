<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('student_parents', function (Blueprint $table) {
            // Ubah menjadi boleh kosong (nullable)
            $table->unsignedBigInteger('ppdb_registration_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('student_parents', function (Blueprint $table) {
            $table->unsignedBigInteger('ppdb_registration_id')->nullable(false)->change();
        });
    }
};