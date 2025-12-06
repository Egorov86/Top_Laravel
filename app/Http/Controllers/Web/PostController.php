<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use App\Repository\CategoryRepository;
use App\Repository\PostCommentRepository;
use App\Repository\PostRepository;
use App\Repository\TagRepository;
use App\Service\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    private const PER_PAGE_ITEMS = 10;

    public function __construct(
        private readonly PostRepository        $postRepository,
        private readonly CategoryRepository    $categoryRepository,
        private readonly PostService           $postService,
        private readonly PostCommentRepository $postCommentRepository,
        private readonly TagRepository         $tagRepository
    )
    {
    }

    public function index(): View
    {
        return view('posts.index', [
            'posts' => $this->postRepository->getAllPaginated(self::PER_PAGE_ITEMS),
        ]);
    }

    public function create(): View
    {
        return view('posts.create', [
            'categories' => $this->categoryRepository,
        ]);
    }

    public function store(PostStoreRequest $postStoreRequest): RedirectResponse
    {
        $this->postRepository->store($postStoreRequest);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Пост успешно создан!');
    }


    public function show(Post $post): View
    {
        return view('posts.show', $this->postRepository->show($post));
    }

    public function edit(string $lang, int $postId): View
    {
        $post = $this->postService->getPostByCache($postId);

        return view('posts.edit', [
            'post' => $post,
            'categories' => $this->categoryRepository->getAllChildren(),
            'comments' => $this->postCommentRepository->getAllPaginated($post, self::PER_PAGE_ITEMS),
            'tags' => $this->tagRepository->getAll()
        ]);
    }

    public function update($lang, PostStoreRequest $postStoreRequest, Post $post): RedirectResponse
    {
        $this->postRepository->update($post, $postStoreRequest);
        $this->tagRepository->sync($post, $postStoreRequest->get('tags'));

        return redirect()->back()->with('success', 'Пост успешно обновлен!');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->postRepository->destroy($post);
        return redirect()->route('posts.index')->with('success', 'Пост успешно удален!');
    }
}
