<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController
{
    public function index(): JsonResponse
    {
        return response()->json(Post::query()->with('user')->paginate(10));
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json(Post::query()->create($request->all()), 201);
    }
}
