@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold mb-6">Редактировать пост</h1>

        {{-- Форма редактирования поста --}}
        <form method="POST" action="{{ route('posts.update', ['lang' => app()->getLocale(), 'post' => $post]) }}">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Текст поста</label>
                <textarea name="content" id="content" rows="6"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          required>{{ old('content', $post->content) }}</textarea>
            </div>
            <div class="mb-6">
                <select name="category_id" id="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($categories as $category)

                        <option value="{{ $category->id }}" @if($category->id === $post->category_id) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>

                <select class="w-full mt-3 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        multiple name="tags[]" id="tags">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}"
                                @if($post->tags->contains($tag->id)) selected @endif>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>

            </div>



            <div class="flex space-x-4">
                @if(auth()->user()->isAdmin() || $post->user_id == auth()->user()->id)
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Обновить
                    </button>
                @endif
                <a href="{{ route('posts.index', ['lang' => app()->getLocale()]) }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                    Отмена
                </a>
            </div>
        </form>
        <div class="flex items-center space-x-2 text-gray-500 text-sm">
            <!-- Иконка глазика (SVG) -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>

            <span class="font-medium">{{ $post->postViews->count() ?? 0 }}</span>
        </div>

        {{-- Лента комментариев --}}
        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">Комментарии</h2>

            @forelse($comments as $comment)
                <div id="comment_{{$comment->id}}" class="border border-gray-200 rounded-md p-3 mb-3 bg-gray-50">
                    <p class="text-gray-700">{{ $comment->comment }}</p>
                    <div class="text-sm text-gray-500 mt-2">
                        Автор: {{ $comment->user->username }} | {{ $comment->created_at->diffForHumans() }}
                    </div>

                    <div class="flex items-center gap-3 mt-3">
                        <form action="{{ route('comments.update', ['lang' => app()->getLocale(), 'postComment' => $comment->id]) }}" method="POST" class="comment-update-form">
                            @csrf
                            @method('PATCH')
                            <button type="button" data-id="{{ $comment->id }}"
                                    class="btn-update-comment px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                Обновить
                            </button>
                        </form>

                        <form action="{{ route('comments.destroy', ['lang' => app()->getLocale(), 'postComment' => $comment]) }}" method="POST" class="comment-delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" data-id="{{ $comment->id }}"
                                    class="btn-delete-comment px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                                Удалить
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Комментариев пока нет.</p>
            @endforelse

            {{ $comments->links() }}
        </div>

        @auth
            <div class="mt-6">
                <form method="POST" action="{{ route('comments.store', $post) }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <textarea name="comment" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:outline-none"
                              placeholder="Написать комментарий..." required></textarea>
                    <button type="submit"
                            class="mt-3 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        Отправить
                    </button>
                </form>
            </div>
        @endauth

    </div>
    <script>
        $(document).ready(function () {
                $.ajax({ type: "GET",
                    url: "{{ route('post.view', ['lang' => app()->getLocale(), 'post' => $post] ) }}",
                    success : function(response)
                    {
                        // $.each(response.data, function (i, item){
                        //    $('#data-box').append(
                        //        '<div style="border: solid 2px black"> <div>ID:' + item.id +'</div>'+
                        //        '<div>CONTENT:' + item.content +'</div></div>'
                        //    )
                        // });
                    }
                });
            $('.btn-update-comment').click(function (){
                let btn = $(this);
                let form = btn.closest('form');
                let id = btn.data('id');
                let commentEl = $('#comment_' + id);

                if (btn.text().trim() === 'Обновить') {
                    let text = commentEl.find('p').text();
                    commentEl.find('p').remove();
                    commentEl.prepend(
                        '<input type="text" class="w-full px-2 py-1 border border-gray-300 rounded mb-2 comment-input" value="' + text + '">'
                    );

                    form.append('<input type="hidden" name="comment" class="hidden-comment-input" value="' + text + '">');

                    commentEl.find('.comment-input').on('input', function () {
                        form.find('.hidden-comment-input').val($(this).val());
                    });

                    btn.text('Сохранить');
                    return;
                }

                if (btn.text().trim() === 'Сохранить') {
                    form.submit();
                }
            });

            $('.btn-delete-comment').click(function () {
                let form = $(this).closest('form');
                let confirmDelete = confirm('Удалить комментарий?');

                if (confirmDelete) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
