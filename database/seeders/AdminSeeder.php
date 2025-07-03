<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'api',
        ]);
        
        $admin = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'super@admin.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'remember_token' => null,
        ]);

        $admin->assignRole($role);
    }
}
