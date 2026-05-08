<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ─── Filament Gate ────────────────────────────────────────────────────────

    /**
     * Tentukan apakah user boleh mengakses Filament Admin Panel.
     * Hanya akun dengan email tertentu atau role admin yang bisa masuk!
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // VVIP PASS: Masukkan email admin / guru ke dalam array ini!
        // Akun Supangat atau pendaftar lain otomatis ditendang (403 Forbidden).
        $allowedEmails = [
            'sukowati@gmail.com', // ← Ganti ini dengan email Admin kamu yang asli
            'admin@gmail.com',    // ← Bisa tambah email kepala sekolah juga di sini
        ];

        return in_array($this->email, $allowedEmails) || in_array($this->role, ['admin', 'superadmin']);
    }

    // ─── Helper ───────────────────────────────────────────────────────────────

    public function isAdmin(): bool
    {
        $allowedEmails = [
            'sukowati@gmail.com',
            'admin@gmail.com',
        ];

        return in_array($this->email, $allowedEmails) || in_array($this->role, ['admin', 'superadmin']);
    }

    // ─── Relasi ───────────────────────────────────────────────────────────────

    /**
     * Setiap user (orang tua/wali) hanya memiliki satu data siswa PPDB.
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Admin yang pernah memverifikasi pendaftaran (bisa banyak).
     */
    public function verifiedRegistrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'verified_by');
    }
}