<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Test Employer',
            'email' => 'employer@test.com',
            'password' => bcrypt('password123'),
            'role' => 'employer',
        ]);

        User::create([
            'name' => 'Test Candidate',
            'email' => 'candidate@test.com',
            'password' => bcrypt('password123'),
            'role' => 'candidate',
        ]);
    }
}