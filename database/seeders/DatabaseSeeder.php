<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(3)->create();

        User::factory()->create([
            'name' => 'Steven Ulloa',
            'email' => 'steven@gmail.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Andy Ulloa',
            'email' => 'andy@gmail.com',
            'password' => bcrypt('password'),
        ]);
    }
}
