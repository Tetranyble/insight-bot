<?php

namespace App\Jobs;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Services\JSonDataClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class PostCreator implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected User $bot, protected int $userId, protected int $count = 10)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(JSonDataClient $client): void
    {
        $posts = $client->posts('GET', "users/{$this->userId}/posts", ['limit' => $this->count]);

        $this->createPost($this->bot, $posts);
    }

    protected function createPost(User $bot, mixed $posts): void
    {

        for ($i = 0; $i < count($posts); $i++) {
            $postName = $posts[$i]->title;
            while (Post::where('name', $postName)->exists()) {
                $postName = $posts[$i]->name."-{$i}-".Str::random();
            }
            $posts = Post::create([
                'name' => $postName,
                'content' => $posts[$i]->body,
                'user_id' => $bot->id,
            ]);
            $posts->each(function ($post) use ($bot, $i, $posts) {
                $this->createComments($post, $bot, $posts[$i]->id);
            });
        }

    }

    protected function createComments(Post $post, User $bot, int $postId): void
    {
        $comments = app(JSonDataClient::class)
            ->comments('GET', "posts/{$postId}/comments", ['limit' => 10]);
        for ($i = 0; $i < count($comments); $i++) {
            Comment::create([
                'user_id' => $bot->id,
                'post_id' => $post->id,
                'comment' => $comments[$i]->body,
            ]);
        }

    }
}
