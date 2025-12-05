<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'phone' => '1234567890',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'prueba@gmail.com'],
            [
                'name' => 'Admin User',
                'phone' => '0987654321',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create 98 additional users
        User::factory(98)->create();

        // Create Categories
        \App\Models\Category::factory(10)->create();

        // Create Posts
        \App\Models\Post::factory(1000)->create();
    }
}
