<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository,
        private PostRepositoryInterface $postRepository
    ) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, string $postId): JsonResponse
    {
        $post = $this->postRepository->find((int) $postId);

        if (!$post) {
            return response()->json(["message" => "Post not found"], 404);
        }

        $data = $request->validated();
        $data["user_id"] = $request->user()->id;
        $data["post_id"] = (int) $postId;

        $comment = $this->commentRepository->create($data);

        return (new CommentResource($comment))->response()->setStatusCode(201);
    }
}
