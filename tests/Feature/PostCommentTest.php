<?php


use App\Models\Post;
use App\Models\PostComment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class PostCommentTest extends TestCase
{
    use DatabaseTransactions;

    //TODO Написать тестирования сервиса (создания, обновления и удаления) комментариев.
    public function test_store()
    {
        /** @var Role $role */
        $role = Role::factory()
            ->create()
            ->first();

        /** @var User $user */
        $user = User::factory([
            'role_id' => $role->id
        ])->create()
            ->first();

        /** @var Post $post */
        $post = Post::factory([
            'user_id' => $user->id
        ])->create()
            ->first();
        $hashText = Str::random(32);

        $response = $this->actingAs($user)->post('/comments', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'comment' => $hashText
        ]);
        $postComment = PostComment::query()
            ->where('comment', $hashText)
            ->orderByDesc('id')
            ->first();

        $response->assertStatus(302);
        $this->assertEquals($hashText, $postComment->comment);
        $this->assertEquals($post->id, $postComment->post_id);
        $this->assertEquals($user->id, $postComment->user_id);
    }

    public function test_update()
    {
        /** @var Role $role */
        $role = Role::factory()
            ->create()
            ->first();

        /** @var User $user */
        $user = User::factory([
            'role_id' => $role->id
        ])->create()
            ->first();

        /** @var Post $post */
        $post = Post::factory([
            'user_id' => $user->id
        ])->create()
            ->first();

        $postComment = PostComment::factory([
            'user_id' => $user->id,
            'post_id' => $post->id
        ])->create()
            ->first();
        $newComment = 'Новый обновленный коммент!';

        $response = $this->actingAs($user)
            ->patch(route('comments.update', $postComment->id), [
                'comment' => $newComment
            ]);

        $response->assertStatus(302);
        $newPostComment = PostComment::query()->find($postComment->id);
        $this->assertEquals($newPostComment->comment, $newComment);
        $this->assertEquals($newPostComment->user_id, $user->id);
        $this->assertEquals($newPostComment->post_id, $post->id);
    }

    public function test_delete(): void
    {
        /** @var Role $role */
        $role = Role::factory()
            ->create()
            ->first();

        /** @var User $user */
        $user = User::factory([
            'role_id' => $role->id
        ])->create()
            ->first();

        /** @var Post $post */
        $post = Post::factory([
            'user_id' => $user->id
        ])->create()
            ->first();

        $postComment = PostComment::factory([
            'user_id' => $user->id,
            'post_id' => $post->id
        ])->create()
            ->first();

        $response = $this->actingAs($user)
            ->delete(route('comments.destroy', $postComment->id));

        $response->assertStatus(302);
        $this->assertNull(PostComment::query()->find($postComment->id));
    }
}
