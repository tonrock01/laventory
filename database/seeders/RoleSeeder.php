<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $admin->givePermissionTo(['assign-role', 'stock-in', 'stock-out', 'create-product', 'view-product', 'edit-product', 'delete-product', 'view-logs']);

        $user = Role::create(['name' => 'staff', 'guard_name' => 'api']);
        $user->givePermissionTo(['stock-in', 'stock-out', 'view-product']);
    }
}
