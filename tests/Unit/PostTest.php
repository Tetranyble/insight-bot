<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->post = Post::factory()->create();
    }

    /**
     * @test
     */
    public function table_has_required_column_fields()
    {
        $this->assertTrue(Schema::hasColumns('posts', [
            'id',
            'name',
            'content',
            'deleted_at',
            'slug',
            'created_at',
            'updated_at',
            'user_id',
        ]));
    }

    /** @test */
    public function post_belong_to_autobot()
    {
        $post = Post::factory()->create();
        $this->assertInstanceOf(User::class, $post->user);
    }

    /** @test */
    public function it_has_comments()
    {
        $comments = Comment::factory(20)
            ->recycle($this->post)
            ->create();
        $this->assertCount(20, $this->post->comments);

    }
}
