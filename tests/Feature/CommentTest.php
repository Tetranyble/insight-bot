<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->post = Post::factory()->create();
    }

    /** @test */
    public function a_post_has_comments(): void
    {

        Comment::factory(20)->create([
            'post_id' => $this->post->id,
        ]);
        $response = $this->getJson(route('v1.posts.comments.index', [
            'post' => $this->post->id,
        ]))
            ->assertStatus(200);

        $response->assertJson(fn (AssertableJson $json) => $json->has('status')
            ->has('message')
            ->has('meta')
            ->has('links')
            ->has('data', 10)
            ->etc()
        );

    }
}
