<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(
        private PostRepositoryInterface $postRepository
    ) {}

    /**
     * Display posts by category.
     */
    public function posts(string $id): JsonResponse
    {
        $posts = $this->postRepository->getPostsByCategory((int) $id);
        return (new PostCollection($posts))->response();
    }
}
