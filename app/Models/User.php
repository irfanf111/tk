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
     * Hanya user dengan role 'admin' atau 'superadmin' yang boleh
     * mengakses Filament Admin Panel. Role 'user' (pendaftar) akan
     * mendapat 403 Forbidden secara otomatis oleh Filament.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    // ─── Helper ───────────────────────────────────────────────────────────────

    /**
     * Cek apakah user adalah admin — murni berbasis kolom `role`.
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'superadmin']);
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

    /**
     * Pembayaran SPP yang dicatat oleh admin ini.
     */
    public function sppPayments(): HasMany
    {
        return $this->hasMany(SppPayment::class, 'dicatat_oleh');
    }
}