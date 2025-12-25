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
                'description' => 'Default role for public registration. Customers can browse, order, and track their orders.',
            ],
            [
                'id' => 2,
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'System administrator with access to user management and system settings.',
            ],
            [
                'id' => 3,
                'name' => 'pimpinan',
                'display_name' => 'Pimpinan',
                'description' => 'Highest level management access. Can manage all aspects of the system including admins.',
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

