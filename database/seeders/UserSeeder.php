<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create()
            ->each(function ($bot) {
                $posts = Post::factory(10)
                    ->recycle($bot)
                    ->create();

                $posts->each(function ($post) {
                    Comment::factory(10)
                        ->recycle(User::factory()->create())
                        ->create([
                            'post_id' => $post->id,
                        ]);
                });
            });
    }
}
