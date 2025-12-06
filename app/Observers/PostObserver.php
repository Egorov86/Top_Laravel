<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    public function created(Post $post): void
    {
        Cache::put('post_' . $post->id, $post);
    }

    public function updated(Post $post): void
    {
        Cache::put('post_' . $post->id, $post);
    }

    public function deleted(Post $post): void
    {
        Cache::forget('post_' . $post->id);
    }
}
