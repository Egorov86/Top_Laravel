<?php

namespace App\Repository;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository
{
    public function getAllChildren(): Collection
    {
        return Category::query()->with('parent')->whereNotNull('parent_id')->get();
    }
}
