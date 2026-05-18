<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator Marketonik',
                'email' => 'admin@marketonik.local',
                'password' => 'admin123',
                'role' => User::ROLE_ADMIN,
            ]
        );
    }
}
