<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menambahkan kolom-kolom data orang tua/wali yang lengkap ke tabel 'student_parents'.
 * Tabel ini sebelumnya hanya memiliki: id, ppdb_registration_id, nama_ayah, nama_ibu, no_hp_ortu, penghasilan.
 * Migration ini menambahkan kolom baru tanpa menghapus kolom lama.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_parents', function (Blueprint $table) {
            // Foreign key baru ke students (relasi utama PPDB baru)
            if (! Schema::hasColumn('student_parents', 'student_id')) {
                $table->foreignId('student_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('students')
                    ->cascadeOnDelete();
            }

            // ── Data Ayah ──
            // nama_ayah sudah ada, cukup tambahkan sisanya
            if (! Schema::hasColumn('student_parents', 'tempat_lahir_ayah')) {
                $table->string('tempat_lahir_ayah')->nullable()->after('nama_ayah');
            }
            if (! Schema::hasColumn('student_parents', 'tanggal_lahir_ayah')) {
                $table->date('tanggal_lahir_ayah')->nullable()->after('tempat_lahir_ayah');
            }
            if (! Schema::hasColumn('student_parents', 'pendidikan_ayah')) {
                $table->string('pendidikan_ayah')->nullable()->after('tanggal_lahir_ayah');
            }
            if (! Schema::hasColumn('student_parents', 'pekerjaan_ayah')) {
                $table->string('pekerjaan_ayah')->nullable()->after('pendidikan_ayah');
            }

            // ── Data Ibu ──
            // nama_ibu sudah ada, tambahkan sisanya
            if (! Schema::hasColumn('student_parents', 'tempat_lahir_ibu')) {
                $table->string('tempat_lahir_ibu')->nullable()->after('nama_ibu');
            }
            if (! Schema::hasColumn('student_parents', 'tanggal_lahir_ibu')) {
                $table->date('tanggal_lahir_ibu')->nullable()->after('tempat_lahir_ibu');
            }
            if (! Schema::hasColumn('student_parents', 'pendidikan_ibu')) {
                $table->string('pendidikan_ibu')->nullable()->after('tanggal_lahir_ibu');
            }
            if (! Schema::hasColumn('student_parents', 'pekerjaan_ibu')) {
                $table->string('pekerjaan_ibu')->nullable()->after('pendidikan_ibu');
            }

            // ── Data Wali (opsional) ──
            if (! Schema::hasColumn('student_parents', 'nama_wali')) {
                $table->string('nama_wali')->nullable()->after('pekerjaan_ibu');
            }
            if (! Schema::hasColumn('student_parents', 'pendidikan_wali')) {
                $table->string('pendidikan_wali')->nullable()->after('nama_wali');
            }
            if (! Schema::hasColumn('student_parents', 'hubungan_wali')) {
                $table->string('hubungan_wali')->nullable()->after('pendidikan_wali');
            }
            if (! Schema::hasColumn('student_parents', 'pekerjaan_wali')) {
                $table->string('pekerjaan_wali')->nullable()->after('hubungan_wali');
            }
        });
    }

    public function down(): void
    {
        Schema::table('student_parents', function (Blueprint $table) {
            if (Schema::hasColumn('student_parents', 'student_id')) {
                $table->dropForeign(['student_id']);
            }

            $newColumns = [
                'student_id', 'tempat_lahir_ayah', 'tanggal_lahir_ayah',
                'pendidikan_ayah', 'pekerjaan_ayah', 'tempat_lahir_ibu',
                'tanggal_lahir_ibu', 'pendidikan_ibu', 'pekerjaan_ibu',
                'nama_wali', 'pendidikan_wali', 'hubungan_wali', 'pekerjaan_wali',
            ];

            $existing = array_filter($newColumns, fn ($c) => Schema::hasColumn('student_parents', $c));
            if ($existing) {
                $table->dropColumn(array_values($existing));
            }
        });
    }
};
