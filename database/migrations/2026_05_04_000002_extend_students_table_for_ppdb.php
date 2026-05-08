<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menambahkan kolom-kolom PPDB lengkap ke tabel 'students'.
 * Tabel ini sebelumnya hanya memiliki: id, nis, ppdb_registration_id, classroom_id, status.
 * Migration ini menambahkan data pribadi siswa tanpa menyentuh kolom lama.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Foreign key ke users (akun pendaftar)
            if (! Schema::hasColumn('students', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->cascadeOnDelete();
            }

            // Identitas diri siswa
            if (! Schema::hasColumn('students', 'nama_lengkap')) {
                $table->string('nama_lengkap')->nullable()->after('user_id');
            }
            if (! Schema::hasColumn('students', 'nama_panggilan')) {
                $table->string('nama_panggilan')->nullable()->after('nama_lengkap');
            }
            if (! Schema::hasColumn('students', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('nama_panggilan');
            }
            if (! Schema::hasColumn('students', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
            }
            if (! Schema::hasColumn('students', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            }
            if (! Schema::hasColumn('students', 'agama')) {
                $table->string('agama')->nullable()->after('tanggal_lahir');
            }
            if (! Schema::hasColumn('students', 'kewarganegaraan')) {
                $table->enum('kewarganegaraan', ['WNI', 'WNA'])->default('WNI')->after('agama');
            }

            // Data keluarga
            if (! Schema::hasColumn('students', 'anak_ke')) {
                $table->integer('anak_ke')->nullable()->after('kewarganegaraan');
            }
            if (! Schema::hasColumn('students', 'jumlah_saudara_kandung')) {
                $table->integer('jumlah_saudara_kandung')->nullable()->after('anak_ke');
            }
            if (! Schema::hasColumn('students', 'jumlah_saudara_tiri')) {
                $table->integer('jumlah_saudara_tiri')->nullable()->after('jumlah_saudara_kandung');
            }
            if (! Schema::hasColumn('students', 'jumlah_saudara_angkat')) {
                $table->integer('jumlah_saudara_angkat')->nullable()->after('jumlah_saudara_tiri');
            }
            if (! Schema::hasColumn('students', 'bahasa_sehari_hari')) {
                $table->string('bahasa_sehari_hari')->nullable()->after('jumlah_saudara_angkat');
            }

            // Data fisik & kesehatan
            if (! Schema::hasColumn('students', 'berat_badan')) {
                $table->float('berat_badan')->nullable()->after('bahasa_sehari_hari');
            }
            if (! Schema::hasColumn('students', 'tinggi_badan')) {
                $table->float('tinggi_badan')->nullable()->after('berat_badan');
            }
            if (! Schema::hasColumn('students', 'golongan_darah')) {
                $table->string('golongan_darah', 5)->nullable()->after('tinggi_badan');
            }
            if (! Schema::hasColumn('students', 'riwayat_penyakit')) {
                $table->text('riwayat_penyakit')->nullable()->after('golongan_darah');
            }

            // Kontak & tempat tinggal
            if (! Schema::hasColumn('students', 'alamat')) {
                $table->text('alamat')->nullable()->after('riwayat_penyakit');
            }
            if (! Schema::hasColumn('students', 'no_hp')) {
                $table->string('no_hp', 20)->nullable()->after('alamat');
            }
            if (! Schema::hasColumn('students', 'tinggal_bersama')) {
                $table->enum('tinggal_bersama', ['orang_tua', 'menumpang', 'asrama', 'kontrak'])
                    ->default('orang_tua')
                    ->nullable()
                    ->after('no_hp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $columns = [
                'user_id', 'nama_lengkap', 'nama_panggilan', 'jenis_kelamin',
                'tempat_lahir', 'tanggal_lahir', 'agama', 'kewarganegaraan',
                'anak_ke', 'jumlah_saudara_kandung', 'jumlah_saudara_tiri',
                'jumlah_saudara_angkat', 'bahasa_sehari_hari', 'berat_badan',
                'tinggi_badan', 'golongan_darah', 'riwayat_penyakit',
                'alamat', 'no_hp', 'tinggal_bersama',
            ];

            // Drop foreign key terlebih dahulu sebelum drop kolom
            if (Schema::hasColumn('students', 'user_id')) {
                $table->dropForeign(['user_id']);
            }

            $existing = array_filter($columns, fn ($c) => Schema::hasColumn('students', $c));
            if ($existing) {
                $table->dropColumn(array_values($existing));
            }
        });
    }
};
