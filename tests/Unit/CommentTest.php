<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function table_has_required_column_fields()
    {
        $this->assertTrue(Schema::hasColumns('comments', [
            'id',
            'comment',
            'post_id',
            'created_at',
            'updated_at',
            'user_id',
        ]));
    }

    /** @test */
    public function it_has_post()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create([
            'post_id' => $post->id,
        ]);

        $this->assertInstanceOf(Post::class, $comment->post);
        $this->assertEquals($post->id, $comment->post_id);
    }

    /** @test */
    public function it_has_author()
    {
        $bot = User::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $bot->id,
        ]);

        $this->assertInstanceOf(User::class, $comment->author);
        $this->assertEquals($bot->id, $comment->user_id);
    }
}
