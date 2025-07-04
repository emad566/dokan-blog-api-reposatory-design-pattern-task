<?php

namespace App\Repositories\Implementations;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository implements CommentRepositoryInterface
{
    public function all(): Collection
    {
        return Comment::all();
    }

    public function find(int $id): ?Comment
    {
        return Comment::find($id);
    }

    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    public function update(Comment $comment, array $data): bool
    {
        return $comment->update($data);
    }

    public function delete(Comment $comment): bool
    {
        return $comment->delete();
    }

    public function getCommentsByPost(int $postId): Collection
    {
        return Comment::with("user:id,name")
            ->where("post_id", $postId)
            ->get();
    }
}
