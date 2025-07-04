<?php

namespace App\Repositories\Implementations;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{
    public function all(): Collection
    {
        return Post::all();
    }

    public function find(int $id): ?Post
    {
        return Post::find($id);
    }

    public function create(array $data): Post
    {
        return Post::create($data);
    }

    public function update(Post $post, array $data): bool
    {
        return $post->update($data);
    }

    public function delete(Post $post): bool
    {
        return $post->delete();
    }

    public function getPostsWithUserAndCategory(): Collection
    {
        return Post::with(["user:id,name", "category:id,name"])
            ->withCount("comments")
            ->get();
    }

    public function getPostWithComments(int $id): ?Post
    {
        return Post::with(["user:id,name", "category:id,name", "comments.user:id,name"])
            ->find($id);
    }

    public function getPostsByCategory(int $categoryId): Collection
    {
        return Post::with(["user:id,name", "category:id,name"])
            ->withCount("comments")
            ->where("category_id", $categoryId)
            ->get();
    }
}
