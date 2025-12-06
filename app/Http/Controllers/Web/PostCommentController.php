<?php

namespace App\Http\Controllers\Web;

use App\Models\PostComment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PostCommentController
{
    //TODO ДЗ УДАЛЕНИЕ КОММЕНТАРИЯ
    public function delete(PostComment $postComment)
    {
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|min:2|max:255',
            'user_id' => 'required|exists:users,id'
        ]);

        $newPostComment = new PostComment();
        $newPostComment->post_id = $validated['post_id'];
        $newPostComment->user_id = $validated['user_id'];
        $newPostComment->comment = $validated['comment'];
        $newPostComment->save();

        return redirect()->route('posts.edit', ['lang' => app()->getLocale(), 'id' => $newPostComment->post_id])->with('success', 'Коммент успешно добавлен!');
    }

    public function update(string $lang, PostComment $postComment, Request $request): RedirectResponse
    {
        $validate = $request->validate([
            'comment' => 'required|min:2|max:255',
        ]);

        /** @var User $user */
        $user = Auth::user();
        if ($postComment->user_id != $user->id && !$user->isAdmin()) {
            throw new AccessDeniedHttpException();
        }
        try {
            $postComment->comment = $validate['comment'];
            $postComment->save();

            return redirect()
                ->route('posts.edit', ['lang' => app()->getLocale(), 'id' => $postComment->post_id])
                ->with('success', 'Коммент успешно обновлен!');
        } catch (\Exception $exception) {
            abort($exception->getCode(), $exception->getMessage());
        }
    }

    public function destroy(PostComment $postComment): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($postComment->user_id != $user->id) {
            throw new AccessDeniedHttpException();
        }
        $postComment->delete();

        return redirect()->route('posts.edit', $postComment->post_id)->with('success', 'Коммент успешно удален!');
    }
}
