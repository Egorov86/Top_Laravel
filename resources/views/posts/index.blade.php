@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Все посты</h1>
    @if(isset($category) && $category)
        <span class="text-3xl font-bold">{{ $category->name }}</span>
    @endif
    <a href="{{ route('posts.create', ['lang' => app()->getLocale()]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
        Создать пост
    </a>

</div>

<div id="data-box" class="space-y-6">
    {{ $posts->links() }}

    @foreach ($posts as $post)
        <div class="bg-white rounded-xl shadow p-6 border border-gray-100 hover:shadow-lg transition">
            {{-- TAGS --}}
            @if($post->tags->isNotEmpty())
                <div class="mb-4 flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                        <span
                            class="px-2 py-1 text-sm font-medium rounded-full border"
                            style="color: {{ $tag->pivot->color }}; border-color: {{ $tag->pivot->color }}; background: {{ $tag->pivot->color }}15">
                {{ $tag->name }}
            </span>
                    @endforeach
                </div>
            @endif
            <!-- Верхняя часть поста -->
            <div class="flex justify-between items-start mb-4">

                <!-- Левая часть: аватар + имя + дата -->
                <div class="flex items-center space-x-4">
                    <img src="{{ $post->user->getAvatarUrl() }}"
                         alt="{{ $post->user->username }}"
                         class="w-14 h-14 rounded-full object-cover shadow">

                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 hover:text-gray-900">
                            {{ $post->user->username }}
                        </h2>

                        <p class="text-gray-400 text-sm">
                            {{ $post->created_at->format('d.m.Y H:i') }}
                        </p>
                    </div>
                </div>

                <!-- Правая часть: кнопки -->
                <div class="flex space-x-3">

                    <a href="{{ route('posts.edit', ['lang' => app()->getLocale(), 'post' => $post, 'id' => $post->id]) }}"
                       class="text-blue-600 hover:text-blue-800 font-medium">
                        ✏ Редактировать
                    </a>

                    @if(Auth::id() === $post->user_id || Auth::user()->isAdmin())
                        <form method="POST"
                              action="{{ route('posts.destroy', ['lang' => app()->getLocale(), 'post' => $post, 'id' => $post->id]) }}"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Удалить пост?')"
                                    class="text-red-600 hover:text-red-800 font-medium">
                                🗑 Удалить
                            </button>
                        </form>
                    @endif

                </div>

            </div>

            <!-- Контент поста -->
            <p class="text-gray-700 leading-relaxed whitespace-pre-line text-base">
                {{ $post->content }}
            </p>

            <!-- Нижняя панель: категория -->
            <div class="mt-4 flex justify-end">
                @php
                    $isFavorite = false;
                    if (Cookie::has('user_' . auth()->id() . '_posts')){
                        $favorites = json_decode(Cookie::get('user_' . auth()->id() . '_posts'), true);
                         $isFavorite = in_array($post->id, $favorites);
                    }
                @endphp
                <a href="{{ route('favorite.session', ['post_id' => $post->id, 'lang' => app()->getLocale()]) }}"
                   class="
        px-4 py-2 rounded-md text-white mr-5
        transition
        @if($isFavorite)
            bg-red-600 hover:bg-red-700
        @else
            bg-blue-600 hover:bg-blue-700
        @endif
   "
                >
                    @if($isFavorite)
                        Убрать из избранных
                    @else
                        Добавить в избранные
                    @endif
                </a>
                <span class="text-sm px-3 py-1 rounded-full bg-gray-100 text-gray-600 border border-gray-200">
                    {{ $post->category->name }}
                </span>

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
            </div>

        </div>
    @endforeach
</div>
    <script>
        $(document).ready(function (){
            $.ajax({ type: "GET",
                url: "{{ route('api.posts.index') }}",
                headers: {
                    Authorization: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.KMUFsIDTnFmyG3nMiGM6H9FNFUROf3wh7SmqJp-QV30'
                },
                data: {
                  page: 1
                },
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


            // $('.btn-favorite').on('click', function (){

            {{--    $.ajax({ type: "GET",--}}
            {{--        url: "{{ route('favorite.session') }}",--}}
            {{--        headers: {--}}
            {{--            Authorization: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.KMUFsIDTnFmyG3nMiGM6H9FNFUROf3wh7SmqJp-QV30'--}}
            {{--        },--}}
            {{--        data: {--}}
            {{--            post_id: $(this).data('id'),--}}
            {{--            user_id: "{{ auth()->id() }}"--}}
            {{--        },--}}
            {{--        success : function(response)--}}
            {{--        {--}}
            {{--            console.log(response)--}}
            {{--        }--}}
            {{--        })--}}
            {{--})--}}
        });
    </script>
@endsection
