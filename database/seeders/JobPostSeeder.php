<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JobPostSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\JobPost::factory(10)->create();
    }
}