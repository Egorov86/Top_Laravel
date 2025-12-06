<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class FavoriteController
{
    public function savePostSession(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id'
        ]);

        $sessionKey = 'user_' . auth()->id() . '_posts';

        $favorites = [];
        if (Cookie::has($sessionKey)) {
            $favorites = json_decode(Cookie::get($sessionKey));
        }

        $postId = (int) $validated['post_id'];

        // Если пост уже есть — удаляем
        if (in_array($postId, $favorites)) {
            $favorites = array_values(array_filter($favorites, fn($id) => $id !== $postId));
        } else {
            // Добавляем
            $favorites[] = $postId;
        }

        Cookie::queue($sessionKey, json_encode($favorites), 60);

        return redirect()->back()->with('success', 'Успешно добавлено в избранные!');
    }
}
