<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_post_comment_to_post(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson("/api/posts/{$post->id}/comments", [
            'content' => 'This is a test comment.',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'content',
                    'user' => ['id', 'name'],
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    public function test_cannot_post_comment_when_unauthenticated(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this->postJson("/api/posts/{$post->id}/comments", [
            'content' => 'This is a test comment.',
        ]);

        $response->assertStatus(401);
    }
}
