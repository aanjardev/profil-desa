<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin Desa',
            'username' => 'superadmin',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
        ]);

        User::create([
            'name' => 'Admin Desa',
            'username' => 'admin',
            'password' => Hash::make('admin12345'),
            'role' => 'admin',
        ]);
    }
}