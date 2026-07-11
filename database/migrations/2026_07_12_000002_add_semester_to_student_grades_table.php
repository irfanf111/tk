<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menambahkan kolom semester ke student_grades agar nilai bisa dibedakan
 * per semester (1 atau 2). Juga menambahkan unique constraint untuk mencegah
 * duplikasi nilai per siswa-kompetensi-tahunajaran-semester.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_grades', function (Blueprint $table) {
            if (! Schema::hasColumn('student_grades', 'semester')) {
                $table->enum('semester', ['1', '2'])
                    ->nullable()
                    ->after('competency_id')
                    ->comment('Semester 1 atau 2');
            }
        });

        // Tambahkan unique constraint setelah kolom ada
        // Menggunakan try-catch karena constraint mungkin sudah ada
        try {
            Schema::table('student_grades', function (Blueprint $table) {
                $table->unique(
                    ['student_id', 'academic_year_id', 'competency_id', 'semester'],
                    'student_grades_unique'
                );
            });
        } catch (\Exception $e) {
            // Constraint mungkin sudah ada, abaikan
        }
    }

    public function down(): void
    {
        Schema::table('student_grades', function (Blueprint $table) {
            // Drop unique constraint dulu
            try {
                $table->dropUnique('student_grades_unique');
            } catch (\Exception $e) {
                // Abaikan jika tidak ada
            }

            if (Schema::hasColumn('student_grades', 'semester')) {
                $table->dropColumn('semester');
            }
        });
    }
};
