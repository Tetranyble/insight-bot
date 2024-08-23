<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function table_has_required_column_fields()
    {
        $this->assertTrue(Schema::hasColumns('users', [
            'id',
            'name',
            'email_verified_at',
            'created_at',
            'updated_at',
            'password',
        ]));
    }

    /**
     * @test
     */
    public function bot_has_posts()
    {
        $bot = User::factory()->create();
        Post::factory(10)
            ->create([
                'user_id' => $bot->id,
            ]);

        $this->assertDatabaseCount('posts', 10);
        $this->assertCount(10, $bot->posts);

    }
}
