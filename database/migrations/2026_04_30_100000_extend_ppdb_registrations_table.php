<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration ini MENAMBAHKAN kolom-kolom baru ke tabel ppdb_registrations
 * yang sudah ada, tanpa menghapus kolom lama agar data eksisting tetap aman.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {

            // ── A. KETERANGAN SISWA (yang belum ada) ──────────────────────────
            // Ubah/tambah nomor_pendaftaran (sudah ada no_pendaftaran, kita tambah
            // kolom baru dengan nama sesuai spesifikasi baru)
            if (! Schema::hasColumn('ppdb_registrations', 'nomor_pendaftaran')) {
                $table->string('nomor_pendaftaran')->nullable()->unique()->after('id');
            }
            // Rename/alias nama: sudah ada nama_lengkap → tambah nama_siswa
            if (! Schema::hasColumn('ppdb_registrations', 'nama_siswa')) {
                $table->string('nama_siswa')->nullable()->after('nomor_pendaftaran');
            }
            // status sebagai enum jika belum
            if (! Schema::hasColumn('ppdb_registrations', 'status')) {
                $table->enum('status', ['pending','verified','accepted','rejected'])
                      ->default('pending');
            }

            // Agama
            if (! Schema::hasColumn('ppdb_registrations', 'agama')) {
                $table->string('agama')->nullable()->after('tanggal_lahir');
            }
            // Kewarganegaraan
            if (! Schema::hasColumn('ppdb_registrations', 'kewarganegaraan')) {
                $table->string('kewarganegaraan')->default('WNI')->nullable();
            }
            // Data keluarga
            if (! Schema::hasColumn('ppdb_registrations', 'anak_ke')) {
                $table->integer('anak_ke')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'jml_saudara_kandung')) {
                $table->integer('jml_saudara_kandung')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'jml_saudara_tiri')) {
                $table->integer('jml_saudara_tiri')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'jml_saudara_angkat')) {
                $table->integer('jml_saudara_angkat')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'bahasa_sehari_hari')) {
                $table->string('bahasa_sehari_hari')->nullable();
            }
            // Data fisik
            if (! Schema::hasColumn('ppdb_registrations', 'berat_badan')) {
                $table->float('berat_badan')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'tinggi_badan')) {
                $table->float('tinggi_badan')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'golongan_darah')) {
                $table->string('golongan_darah')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'riwayat_penyakit')) {
                $table->string('riwayat_penyakit')->nullable();
            }
            // Kontak & tempat tinggal
            if (! Schema::hasColumn('ppdb_registrations', 'alamat')) {
                $table->text('alamat')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'no_hp')) {
                $table->string('no_hp')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'tinggal_bersama')) {
                $table->string('tinggal_bersama')->nullable();
            }

            // ── B. ORANG TUA / WALI ───────────────────────────────────────────
            if (! Schema::hasColumn('ppdb_registrations', 'nama_ayah')) {
                $table->string('nama_ayah')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'tempat_lahir_ayah')) {
                $table->string('tempat_lahir_ayah')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'tanggal_lahir_ayah')) {
                $table->date('tanggal_lahir_ayah')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'nama_ibu')) {
                $table->string('nama_ibu')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'tempat_lahir_ibu')) {
                $table->string('tempat_lahir_ibu')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'tanggal_lahir_ibu')) {
                $table->date('tanggal_lahir_ibu')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'pendidikan_ayah')) {
                $table->string('pendidikan_ayah')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'pendidikan_ibu')) {
                $table->string('pendidikan_ibu')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'pekerjaan_ayah')) {
                $table->string('pekerjaan_ayah')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'pekerjaan_ibu')) {
                $table->string('pekerjaan_ibu')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'nama_wali')) {
                $table->string('nama_wali')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'pendidikan_wali')) {
                $table->string('pendidikan_wali')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'hubungan_anak_wali')) {
                $table->string('hubungan_anak_wali')->nullable();
            }
            if (! Schema::hasColumn('ppdb_registrations', 'pekerjaan_wali')) {
                $table->string('pekerjaan_wali')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $columns = [
                'nomor_pendaftaran','nama_siswa',
                'agama','kewarganegaraan','anak_ke',
                'jml_saudara_kandung','jml_saudara_tiri','jml_saudara_angkat',
                'bahasa_sehari_hari','berat_badan','tinggi_badan',
                'golongan_darah','riwayat_penyakit','alamat','no_hp','tinggal_bersama',
                'nama_ayah','tempat_lahir_ayah','tanggal_lahir_ayah',
                'nama_ibu','tempat_lahir_ibu','tanggal_lahir_ibu',
                'pendidikan_ayah','pendidikan_ibu','pekerjaan_ayah','pekerjaan_ibu',
                'nama_wali','pendidikan_wali','hubungan_anak_wali','pekerjaan_wali',
            ];
            // Drop hanya kolom yang ada agar rollback aman
            $existing = array_filter($columns, fn($c) => Schema::hasColumn('ppdb_registrations', $c));
            if ($existing) {
                $table->dropColumn(array_values($existing));
            }
        });
    }
};
