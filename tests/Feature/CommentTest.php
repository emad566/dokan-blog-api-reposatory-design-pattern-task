<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
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

    public function test_can_update_own_comment(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->putJson("/api/comments/{$comment->id}", [
            'content' => 'Updated comment content.',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'content' => 'Updated comment content.',
                ]
            ]);
    }

    public function test_cannot_update_other_users_comment(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user1->id,
            'category_id' => $category->id,
        ]);
        $comment = Comment::factory()->create([
            'user_id' => $user1->id,
            'post_id' => $post->id,
        ]);

        Sanctum::actingAs($user2);

        $response = $this->putJson("/api/comments/{$comment->id}", [
            'content' => 'Updated comment content.',
        ]);

        $response->assertStatus(403);
    }

    public function test_can_delete_own_comment(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->deleteJson("/api/comments/{$comment->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Comment deleted successfully']);
    }

    public function test_cannot_delete_other_users_comment(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user1->id,
            'category_id' => $category->id,
        ]);
        $comment = Comment::factory()->create([
            'user_id' => $user1->id,
            'post_id' => $post->id,
        ]);

        Sanctum::actingAs($user2);

        $response = $this->deleteJson("/api/comments/{$comment->id}");

        $response->assertStatus(403);
    }
}
