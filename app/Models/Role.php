<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    /**
     * Get the users for the role.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if role is admin.
     */
    public function isAdmin(): bool
    {
        return $this->name === 'admin';
    }

    /**
     * Check if role is manajemen.
     */
    public function isManajemen(): bool
    {
        return $this->name === 'manajemen';
    }

    /**
     * Check if role is pelanggan.
     */
    public function isPelanggan(): bool
    {
        return $this->name === 'pelanggan';
    }

     public function isProduksi(): bool
    {
        return $this->name === 'produksi';
    }
}

