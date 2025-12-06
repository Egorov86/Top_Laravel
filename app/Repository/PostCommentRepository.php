<?php

namespace App\Repository;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class PostCommentRepository
{
    public function getAllPaginated(Post $post, ?int $perPage = 10): LengthAwarePaginator
    {
        return $post->comments()->orderByDesc('created_at')->paginate($perPage);
    }
}
