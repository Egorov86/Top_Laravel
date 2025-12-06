@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Заголовок профиля -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center space-x-6 mb-4">
            <img src="{{ $user->getAvatarUrl() }}"
                 alt="{{ $user->username }}"
                 class="w-20 h-20 rounded-full object-cover border-2 border-gray-200">
            <div>
                <h1 class="text-3xl font-bold">Профиль пользователя: {{ $user->username }}</h1>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600"><strong>Email:</strong> {{ $user->email }}</p>
                <p class="text-gray-600"><strong>Статус:</strong> 
                    <span class="inline-block bg-{{ $user->status === 'admin' ? 'red' : 'blue' }}-100 text-{{ $user->status === 'admin' ? 'red' : 'blue' }}-800 text-xs px-2 py-1 rounded">
                        {{ $user->status === 'admin' ? 'Администратор' : 'Пользователь' }}
                    </span>
                </p>
            </div>
            <div>
                <p class="text-gray-600"><strong>Зарегистрирован:</strong> {{ $user->created_at->format('d.m.Y') }}</p>
                <p class="text-gray-600"><strong>Постов:</strong> {{ $user->posts->count() }}</p>
            </div>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-4">Посты пользователя</h2>
    
    @if($posts->count() > 0)
    <div class="space-y-6">
        @foreach($posts as $post)
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start mb-4">
                <!-- Левая часть с аватаром и датой -->
                <div class="flex items-center space-x-4">
                    <img src="{{ $user->getAvatarUrl() }}"
                         alt="{{ $user->username }}"
                         class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <p class="text-gray-500 text-sm">{{ $post->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                </div>
            </div>
            <p class="text-gray-700 whitespace-pre-line">{{ $post->content }}</p>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <p class="text-gray-600">У этого пользователя пока нет постов.</p>
    </div>
    @endif
</div>
@endsection