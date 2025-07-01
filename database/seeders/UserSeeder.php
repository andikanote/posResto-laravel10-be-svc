<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // In UserSeeder.php
        $user = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super4dmin@posin.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'roles' => 'ADMIN', // Changed to uppercase
        ]);
    }
}
