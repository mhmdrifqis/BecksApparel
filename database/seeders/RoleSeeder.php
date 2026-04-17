<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'pelanggan',
                'display_name' => 'Pelanggan',
                'description' => 'Pengguna akhir yang melakukan pemesanan, pembayaran, dan pelacakan order.',
            ],
            [
                'id' => 2,
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Pengelola penuh sistem, manajemen user, produk, stok, dan transaksi.',
            ],
            [
                'id' => 3,
                'name' => 'manajemen', // Merepresentasikan Manajemen PT Bola Media Sportainment
                'display_name' => 'Manajemen / Pimpinan',
                'description' => 'Akses read-only untuk monitoring data operasional, laporan keuangan, dan analitik.',
            ],
            [
                'id' => 4, // ROLE BARU DITAMBAHKAN
                'name' => 'produksi',
                'display_name' => 'Tim Produksi',
                'description' => 'Bertanggung jawab memproses pesanan (Cetak -> Jahit -> QC -> Siap Kirim) dan update status produksi.',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['id' => $role['id']],
                $role
            );
        }
    }
}