@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
    <h1 class="text-3xl font-bold mb-6">Создать пост</h1>

    <form method="POST" action="{{ route('posts.store', ['lang' => app()->getLocale()]) }}">
        @csrf

        <div class="mb-6">
            <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Текст поста</label>
            <textarea name="content" id="content" rows="6"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                      required placeholder="Напишите что-нибудь...">{{ old('content') }}</textarea>
        </div>

        <div class="mb-6">
            <select name="category_id" id="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Опубликовать
            </button>
            <a href="{{ route('posts.index', ['lang' => app()->getLocale()]) }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                Отмена
            </a>
        </div>
    </form>
</div>
@endsection
