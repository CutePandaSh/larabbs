<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function saved(Category $category)
    {
        \Cache::forget($category->cache_key);
    }

    public function deleted(Category $category)
    {
        \Cache::forget($category->cache_key);
    }
}
