<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Menghubungkan tabel lpad_students dengan tabel students (PPDB).
 * Kolom student_id dibuat nullable agar data lama (sebelum PPDB) tetap valid.
 * Siswa baru dari PPDB akan otomatis terhubung via student_id ini.
 *
 * Catatan SQLite: SQLite tidak mendukung ALTER TABLE ADD FOREIGN KEY.
 * Kita gunakan pendekatan recreate table yang aman dengan preservasi data.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah kolom sudah ada (idempotent)
        if (Schema::hasColumn('lpad_students', 'student_id')) {
            return;
        }

        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            // SQLite: harus recreate table untuk tambah FK
            // 1. Buat tabel baru dengan kolom student_id
            Schema::create('lpad_students_new', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->nullable()->constrained('students')->nullOnDelete();
                $table->string('no_induk')->unique();
                $table->string('nama_lengkap');
                $table->date('tanggal_lahir');
                $table->timestamps();
            });

            // 2. Salin data dari tabel lama ke tabel baru
            DB::statement('INSERT INTO lpad_students_new (id, no_induk, nama_lengkap, tanggal_lahir, created_at, updated_at)
                           SELECT id, no_induk, nama_lengkap, tanggal_lahir, created_at, updated_at
                           FROM lpad_students');

            // 3. Drop tabel lama dan rename tabel baru
            Schema::drop('lpad_students');
            DB::statement('ALTER TABLE lpad_students_new RENAME TO lpad_students');
        } else {
            // MySQL/PostgreSQL: bisa langsung ALTER TABLE
            Schema::table('lpad_students', function (Blueprint $table) {
                $table->foreignId('student_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('students')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if (! Schema::hasColumn('lpad_students', 'student_id')) {
            return;
        }

        if ($driver === 'sqlite') {
            // SQLite: recreate table tanpa kolom student_id
            Schema::create('lpad_students_rollback', function (Blueprint $table) {
                $table->id();
                $table->string('no_induk')->unique();
                $table->string('nama_lengkap');
                $table->date('tanggal_lahir');
                $table->timestamps();
            });

            DB::statement('INSERT INTO lpad_students_rollback (id, no_induk, nama_lengkap, tanggal_lahir, created_at, updated_at)
                           SELECT id, no_induk, nama_lengkap, tanggal_lahir, created_at, updated_at
                           FROM lpad_students');

            Schema::drop('lpad_students');
            DB::statement('ALTER TABLE lpad_students_rollback RENAME TO lpad_students');
        } else {
            Schema::table('lpad_students', function (Blueprint $table) {
                $table->dropForeign(['student_id']);
                $table->dropColumn('student_id');
            });
        }
    }
};
