<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Driver user
        User::updateOrCreate([
            'email' => 'driver@example.com',
        ], [
            'name' => 'Driver User',
            'password' => Hash::make('password'),
            'role' => 'driver',
        ]);
    }
}
