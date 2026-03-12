<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'employer@test.com'],
            [
                'name'     => 'Test Employer',
                'password' => bcrypt('password123'),
                'role'     => 'employer',
            ]
        );

        User::firstOrCreate(
            ['email' => 'candidate@test.com'],
            [
                'name'     => 'Test Candidate',
                'password' => bcrypt('password123'),
                'role'     => 'candidate',
            ]
        );
    }
}