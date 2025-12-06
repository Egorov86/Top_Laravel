<?php

namespace App\Repository;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Ramsey\Collection\Collection;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PostRepository
{
    public function getAllPaginated(?int $perPage = 10): LengthAwarePaginator
    {
        return Post::with('user')->paginate($perPage);
    }

    public function store(PostStoreRequest $postStoreRequest): Post
    {
        /** @var User $user */
        $user = Auth::user();

       return Post::query()->create([
            'content' => $postStoreRequest->get('content'),
            'user_id' => $user->id,
            'category_id' => $postStoreRequest->get('category_id'),
        ]);
    }

    public function show(Post $post): Post
    {
        return $post;
    }

    public function update(Post $post, PostStoreRequest $postStoreRequest): Post
    {
        /** @var User $user */
        $user = Auth::user();
        $isAdmin = $user->isAdmin();

        if ($post->user_id !== $user->id && !$isAdmin) {
            abort(403);
        }

        $post->category_id = $postStoreRequest->get('category_id');
        $post->content = $postStoreRequest->get('content');
        $post->save();


        return $post;
    }

    public function destroy(Post $post): void
    {
        /** @var User $user */
        $user = Auth::user();
        $isAdmin = $user->isAdmin();
        if ($post->user_id !== $user->id && !$isAdmin) {
            abort(403);
        }

        if (!$post->delete()) {
            throw new BadRequestHttpException();
        }
    }
}
