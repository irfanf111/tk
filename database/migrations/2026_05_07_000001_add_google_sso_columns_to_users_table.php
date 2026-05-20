<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom google_id dan avatar ke tabel users
     * untuk mendukung SSO Google via Laravel Socialite.
     * Password dibuat nullable agar user yang daftar via Google
     * tidak wajib memiliki password.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom google_id: menyimpan unique ID dari akun Google
            if (!Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id')->nullable()->unique()->after('email');
            }

            // Kolom avatar: menyimpan URL foto profil dari Google
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('google_id');
            }

            // Buat password nullable agar user SSO tidak wajib punya password
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Rollback: hapus kolom yang ditambahkan dan kembalikan password ke NOT NULL.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('users', 'google_id')) {
                $columns[] = 'google_id';
            }
            if (Schema::hasColumn('users', 'avatar')) {
                $columns[] = 'avatar';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
            $table->string('password')->nullable(false)->change();
        });
    }
};
