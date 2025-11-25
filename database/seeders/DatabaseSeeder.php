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
        // 1. Create a specific test user
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 2. Create some categories
        $categories = \App\Models\Category::factory(5)->create();

        // 3. Create 100 posts
        // We recycle the categories and the test user (plus some random users)
        \App\Models\Post::factory(100)
            ->recycle($categories)
            ->recycle($user) // Ensure test user has some posts
            ->create()
            ->each(function ($post) {
                // Add 0-5 comments to each post
                \App\Models\Comment::factory(rand(0, 5))->create([
                    'post_id' => $post->id,
                    'user_id' => \App\Models\User::factory(), // Random users for comments
                ]);
            });
    }
}
