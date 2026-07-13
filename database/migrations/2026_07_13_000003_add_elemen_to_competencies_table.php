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
        Schema::table('competencies', function (Blueprint $table) {
            if (!Schema::hasColumn('competencies', 'elemen')) {
                $table->string('elemen', 50)->nullable()->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('competencies', function (Blueprint $table) {
            if (Schema::hasColumn('competencies', 'elemen')) {
                $table->dropColumn('elemen');
            }
        });
    }
};
