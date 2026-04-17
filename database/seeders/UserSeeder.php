<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

         // 3. Buat Akun Pelanggan (Role ID 1)
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Pelanggan Setia',
                'password' => Hash::make('password'),
                'role_id' => 1, // ID untuk Pelanggan
                'nomor_telepon' => '081200000003',
            ]
        );

        // 1. Buat Akun Admin (Role ID 2)
        User::updateOrCreate(
            ['email' => 'admin@becks.com'],
            [
                'name' => 'Admin Becks',
                'password' => Hash::make('password'),
                'role_id' => 2, // ID untuk Admin
                'nomor_telepon' => '081200000001',
            ]
        );

        // 2. Buat Akun Pimpinan (Role ID 3)
        User::updateOrCreate(
            ['email' => 'manajemens@becks.com'],
            [
                'name' => 'Tim Manajemen',
                'password' => Hash::make('password'),
                'role_id' => 3, // ID untuk Pimpinan
                'nomor_telepon' => '081200000002',
            ]
        );

        // 4. Buat Akun Tim Produksi (Role ID 4)
        User::updateOrCreate(
            ['email' => 'produksi@becks.com'],
            [
                'name' => 'Kepala Produksi',
                'password' => Hash::make('password'),
                'role_id' => 4, // ID untuk Produksi
                'nomor_telepon' => '081200000004',
            ]
        );
    }
}