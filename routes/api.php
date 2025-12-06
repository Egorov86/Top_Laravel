<?php

use App\Http\Controllers\API\PostController;
use App\Http\Middleware\CheckHeaderMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckHeaderMiddleware::class])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('api.posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('api.posts.store');
});
