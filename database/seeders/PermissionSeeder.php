<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'assign-role', 'guard_name' => 'api']);
        Permission::create(['name' => 'stock-in', 'guard_name' => 'api']);
        Permission::create(['name' => 'stock-out', 'guard_name' => 'api']);
        Permission::create(['name' => 'create-product', 'guard_name' => 'api']);
        Permission::create(['name' => 'view-product', 'guard_name' => 'api']);
        Permission::create(['name' => 'edit-product', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete-product', 'guard_name' => 'api']);
        Permission::create(['name' => 'view-logs', 'guard_name' => 'api']);
    }
}
