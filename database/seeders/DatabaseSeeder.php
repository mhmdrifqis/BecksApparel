<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // ==========================================
        // 1. SEEDER ROLES
        // ==========================================
        $roles = [
            ['id' => 1, 'role_name' => 'Admin'],
            ['id' => 2, 'role_name' => 'Pimpinan'],
            ['id' => 3, 'role_name' => 'Tim Produksi'],
            ['id' => 4, 'role_name' => 'Pelanggan'],
        ];
        DB::table('roles')->insert($roles);

        // ==========================================
        // 2. SEEDER USERS (Password default: password)
        // ==========================================
        $users = [
            [
                'id' => 1, 'role_id' => 1, 'name' => 'Super Admin', 
                'email' => 'admin@becks.com', 'password' => Hash::make('password'), 
                'phone' => '08111111111', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => 2, 'role_id' => 2, 'name' => 'Bapak Pimpinan', 
                'email' => 'pimpinan@becks.com', 'password' => Hash::make('password'), 
                'phone' => '08222222222', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => 3, 'role_id' => 3, 'name' => 'Tim Produksi', 
                'email' => 'produksi@becks.com', 'password' => Hash::make('password'), 
                'phone' => '08333333333', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => 4, 'role_id' => 4, 'name' => 'Pelanggan Setia', 
                'email' => 'pelanggan@becks.com', 'password' => Hash::make('password'), 
                'phone' => '08444444444', 'created_at' => $now, 'updated_at' => $now
            ],
        ];
        DB::table('users')->insert($users);

        // ==========================================
        // 3. SEEDER ALAMAT PELANGGAN
        // ==========================================
        DB::table('addresses')->insert([
            'user_id' => 4,
            'recipient_name' => 'Pelanggan Setia',
            'phone' => '08444444444',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40132',
            'full_address' => 'Jl. Ir. H. Juanda No. 100, Dago',
            'is_default' => true,
        ]);

        // ==========================================
        // 4. SEEDER PRODUK
        // ==========================================
        $products = [
            [
                'id' => 1,
                'name' => 'Jersey Full Print Premium',
                'description' => 'Jersey olahraga dengan bahan dry-fit premium dan sablon sublimasi full color.',
                'base_price' => 150000,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => 2,
                'name' => 'Kaos Cotton Combed 30s',
                'description' => 'Kaos santai bahan katun combed 30s super adem dengan sablon DTF awet.',
                'base_price' => 85000,
                'created_at' => $now, 'updated_at' => $now
            ]
        ];
        DB::table('products')->insert($products);

        // ==========================================
        // 5. SEEDER VARIAN (UKURAN & WARNA)
        // ==========================================
        // Ukuran untuk Jersey (ID: 1)
        DB::table('product_sizes')->insert([
            ['product_id' => 1, 'size_name' => 'M', 'additional_price' => 0],
            ['product_id' => 1, 'size_name' => 'L', 'additional_price' => 0],
            ['product_id' => 1, 'size_name' => 'XL', 'additional_price' => 10000],
            ['product_id' => 1, 'size_name' => 'XXL', 'additional_price' => 20000],
        ]);

        // Warna untuk Kaos (ID: 2)
        DB::table('product_colors')->insert([
            ['product_id' => 2, 'color_name' => 'Hitam Solid', 'hex_code' => '#000000'],
            ['product_id' => 2, 'color_name' => 'Putih Bersih', 'hex_code' => '#FFFFFF'],
            ['product_id' => 2, 'color_name' => 'Navy Blue', 'hex_code' => '#000080'],
        ]);

        // ==========================================
        // 6. SEEDER BAHAN BAKU (MATERIALS)
        // ==========================================
        $materials = [
            ['name' => 'Kain Dry-Fit Milano (Roll)', 'stock' => 15, 'minimum_stock' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kain Cotton Combed 30s Hitam (Roll)', 'stock' => 8, 'minimum_stock' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Tinta Sublimasi Cyan (Liter)', 'stock' => 10, 'minimum_stock' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kertas Sublim (Roll)', 'stock' => 5, 'minimum_stock' => 2, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('materials')->insert($materials);
    }
}