<?php

namespace App\Service;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostService
{
    public function getPostByCache(int $postId): Post
    {
        if (Cache::has('post_' . $postId)) {
            $post = Cache::get('post_' . $postId);
        } else {
            $post = Post::query()->findOrFail($postId);
            Cache::put('post_' . $postId, $post, 60);
        }

        return $post;
    }
}
