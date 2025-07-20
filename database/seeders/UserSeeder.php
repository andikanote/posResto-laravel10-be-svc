<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super4dmin@posin.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'roles' => 'ADMIN',
        ]);

        UserProfile::factory()->create([
            'user_id' => $admin->id,
            'bio' => 'Administrator sistem',
        ]);

        // Create regular users
        User::factory(1)
            ->hasProfile()
            ->create();
    }
}
