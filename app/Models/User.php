<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role_id',
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

    /**
     * Get the role that owns the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if user has specific role.
     */
    public function hasRole($role)
    {
        // 1. Normalisasi teks menjadi huruf kecil semua biar aman
        $role = strtolower($role);

        // 2. Daftar Mapping sesuai Database Seeder kita
        $roles = [
            'admin'     => 1,
            'pimpinan'  => 2,
            'produksi'  => 3, // Di route tulis 'produksi', di DB id 3
            'pelanggan' => 4,
        ];

        // 3. Cek apakah role_id user sama dengan yang diminta
        if (isset($roles[$role])) {
            return $this->role_id === $roles[$role];
        }

        return false;
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        // return $this->hasRole('admin');
        return $this->role_id === 1;
    }

    /**
     * Check if user is manajemen.
     */
    public function isManajemen(): bool
    {
        // return $this->hasRole('manajemen');
        return $this->role_id === 2;
    
    }


    /**
     * Cek apakah user adalah Tim Produksi.
     */
    public function isProduksi(): bool
    {
        // return $this->hasRole('produksi');
        return $this->role_id === 3;    
    }

    /**
     * Check if user is pelanggan.
     */
    public function isPelanggan(): bool
    {
        // return $this->hasRole('pelanggan');
        return $this->role_id === 4;
    }

    /**
     * Get user's role name.
     */
    public function getRoleName(): ?string
    {
        return $this->role ? $this->role->role_name : null;
    }

    /**
     * Get user's role display name.
     */
    public function getRoleDisplayName(): ?string
    {
        return $this->role ? $this->role->display_name : null;
    }

    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
