<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Observers\PostObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $globalCategories = Category::query()
            ->with(['children.children', 'parent'])
            ->whereNull('parent_id')
            ->get();

        View::composer('*', function ($view) use ($globalCategories) {
            $view->with('globalCategories', $globalCategories);
        });

        Post::observe(PostObserver::class);
    }
}
