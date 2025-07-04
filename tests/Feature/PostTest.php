<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_post_as_authenticated_user(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
            'category_id' => $category->id,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'content',
                    'user' => ['id', 'name'],
                    'category' => ['id', 'name'],
                    'comments_count',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    public function test_cannot_create_post_when_unauthenticated(): void
    {
        $category = Category::factory()->create();

        $response = $this->postJson('/api/posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
            'category_id' => $category->id,
        ]);

        $response->assertStatus(401);
    }

    public function test_can_view_post_with_comments(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = \App\Models\Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this->getJson("/api/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'content',
                    'user' => ['id', 'name'],
                    'category' => ['id', 'name'],
                    'comments',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
}
