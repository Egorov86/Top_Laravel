<?php

namespace App\Repository;

use App\Models\Post;
use App\Models\Tag;
use App\Service\TagService;
use Illuminate\Support\Collection;

class TagRepository
{
    public function __construct(
        private readonly TagService $tagService
    )
    {
    }

    public function getAll(): Collection
    {
        return Tag::query()->get();
    }

    public function sync(Post $post, array $tagsIds): void
    {
        $syncData = [];
        foreach ($tagsIds as $tagId) {
            $syncData[$tagId] = ['color' => $this->tagService->randomColor()];
        }

        $post->tags()->sync($syncData);
    }
}
