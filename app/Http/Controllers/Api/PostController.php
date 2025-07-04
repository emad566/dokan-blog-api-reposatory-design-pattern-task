<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private PostRepositoryInterface $postRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $posts = $this->postRepository->getPostsWithUserAndCategory();
        return (new PostCollection($posts))->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $this->authorize('create', Post::class);

        $data = $request->validated();
        $data["user_id"] = $request->user()->id;

        $post = $this->postRepository->create($data);

        return (new PostResource($post))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): JsonResponse
    {
        $this->authorize('view', $post);

        $post = $this->postRepository->getPostWithComments($post->id);

        if (!$post) {
            return response()->json(["message" => "Post not found"], 404);
        }

        return (new PostResource($post))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $this->authorize('update', $post);

        $data = $request->validated();
        $this->postRepository->update($post, $data);

        $post->load(['user:id,name', 'category:id,name']);

        return (new PostResource($post))->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): JsonResponse
    {
        $this->authorize('delete', $post);

        $this->postRepository->delete($post);

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
