<?php

namespace App\Repositories\Interfaces;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Post;
    public function create(array $data): Post;
    public function update(Post $post, array $data): bool;
    public function delete(Post $post): bool;
    public function getPostsWithUserAndCategory(): Collection;
    public function getPostWithComments(int $id): ?Post;
    public function getPostsByCategory(int $categoryId): Collection;
}
