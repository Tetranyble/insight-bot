<?php

namespace App\Jobs;

use App\Models\Autobot;
use App\Models\Comment;
use App\Models\Post;
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
    public function __construct(protected Autobot $bot, protected int $count = 10)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->createPost($this->bot, $this->count);
    }

    protected function createPost(Autobot $bot, int $count = 10): void
    {
        for ($i = 0; $i < $count; $i++) {
            $postName = $bot->name.Str::random();
            while (Post::where('name', $postName)->exists()) {
                $postName = $bot->name."-{$i}".Str::random();
            }
            $posts = Post::create([
                'name' => $postName,
                'content' => "this quick brown fox leap over the lazy dog {$i}",
                'autobot_id' => $bot->id,
            ]);
            $posts->each(function ($post) use ($bot) {
                $this->createComments($post, $bot, 10);
            });
        }

    }

    protected function createComments(Post $post, Autobot $bot, int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            Comment::create([
                'autobot_id' => $bot->id,
                'post_id' => $post->id,
                'comment' => "The new comment section for {$bot->name}",
            ]);
        }

    }
}
