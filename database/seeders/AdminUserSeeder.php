<?php
// database/seeders/AdminUserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'status' => 'admin',
        ]);

        User::create([
            'username' => 'user1',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
            'status' => 'user',
        ]);
    }
}