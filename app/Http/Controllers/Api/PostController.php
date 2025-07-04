<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
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
        $data = $request->validated();
        $data["user_id"] = $request->user()->id;

        $post = $this->postRepository->create($data);

        return (new PostResource($post))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $post = $this->postRepository->getPostWithComments((int) $id);

        if (!$post) {
            return response()->json(["message" => "Post not found"], 404);
        }

        return (new PostResource($post))->response();
    }
}
