<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // User Biasa 1
        User::create([
            'name' => 'Septi Amellia',
            'email' => 'septi@mail.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // User Biasa 2
        User::create([
            'name' => 'Fakhrur Rizal',
            'email' => 'fakhrur@mail.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        $this->command->info('✅ UserSeeder berhasil dijalankan!');
        $this->command->info('   Admin     : admin@mail.com / password');
        $this->command->info('   User 1    : septi@mail.com / password');
        $this->command->info('   User 2    : fakhrur@mail.com / password');
    }
}