<?php

namespace App\Repositories\Interfaces;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Comment;
    public function create(array $data): Comment;
    public function update(Comment $comment, array $data): bool;
    public function delete(Comment $comment): bool;
    public function getCommentsByPost(int $postId): Collection;
}
