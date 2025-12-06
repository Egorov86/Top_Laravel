<!-- resources/views/users/profile.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
    <h1 class="text-3xl font-bold mb-6">Мой профиль</h1>

    <!-- Отображение аватарки -->
    <div class="mb-6 text-center">
        <div class="relative inline-block">
            <img src="{{ $user->getAvatarUrl() }}"
                alt="Аватар"
                class="w-32 h-32 rounded-full object-cover border-4 border-blue-500 mx-auto">
            @if($user->avatar)
            <form method="POST" action="{{ route('avatar.remove') }}" class="absolute top-0 right-0">
                @csrf
                <button type="submit"
                    class="bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm hover:bg-red-600"
                    onclick="return confirm('Удалить аватарку?')">
                    ×
                </button>
            </form>
            @endif
        </div>
        <p class="text-gray-600 mt-2">Текущая аватарка</p>
    </div>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Имя пользователя</label>
                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div>
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>
        </div>

        <!-- Поле для загрузки аватарки -->
        <div class="mb-6">
            <label for="avatar" class="block text-gray-700 text-sm font-bold mb-2">Аватарка</label>
            <input type="file" name="avatar" id="avatar"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                accept="image/*">
            <p class="text-gray-500 text-xs mt-1">Поддерживаемые форматы: JPEG, PNG, JPG, GIF. Максимальный размер: 2MB</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Новый пароль</label>
                <input type="password" name="password" id="password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    minlength="6">
                <p class="text-gray-500 text-xs mt-1">Оставьте пустым, если не хотите менять</p>
            </div>

            <div>
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Подтверждение пароля</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    minlength="6">
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Обновить профиль
        </button>
    </form>
</div>

<!-- Скрипт для предпросмотра аватарки -->
<script>
    document.getElementById('avatar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('img[alt="Аватар"]').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection