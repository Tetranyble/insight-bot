<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function autobot_has_posts(): void
    {
        Post::factory(20)->create([
            'user_id' => $this->user->id,
        ]);
        $response = $this->getJson(route('v1.autobots.posts.index', [
            'user' => $this->user->id,
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
