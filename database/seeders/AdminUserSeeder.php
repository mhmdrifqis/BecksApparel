<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@becksapparel.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@becksapparel.com',
                'nomor_telepon' => '081234567890',
                'password' => Hash::make('password'),
                'role_id' => 2, // Admin role
                'email_verified_at' => now(),
            ]
        );

        // Create Pimpinan User
        User::updateOrCreate(
            ['email' => 'pimpinan@becksapparel.com'],
            [
                'name' => 'Pimpinan',
                'email' => 'pimpinan@becksapparel.com',
                'nomor_telepon' => '081234567891',
                'password' => Hash::make('password'),
                'role_id' => 3, // Pimpinan role
                'email_verified_at' => now(),
            ]
        );
    }
}

