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
            'email' => 'superadmin@desa.id',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
        ]);

        User::create([
            'name' => 'Admin Desa',
            'email' => 'admin@desa.id',
            'password' => Hash::make('admin12345'),
            'role' => 'admin',
        ]);
    }
}