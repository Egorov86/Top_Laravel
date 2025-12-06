@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6 text-center">Регистрация</h2>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="mb-4">
            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Имя пользователя</label>
            <input type="text" name="username" id="username" value="{{ old('username') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required autofocus>
            <p class="text-gray-500 text-xs mt-1">Уникальное имя для входа в систему</p>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Пароль</label>
            <input type="password" name="password" id="password" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required minlength="6">
            <p class="text-gray-500 text-xs mt-1">Минимум 6 символов</p>
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Подтверждение пароля</label>
            <input type="password" name="password_confirmation" id="password_confirmation" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required minlength="6">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Зарегистрироваться
        </button>
    </form>

    <div class="mt-4 text-center">
        <p class="text-gray-600">Уже есть аккаунт? 
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Войти</a>
        </p>
    </div>
</div>
@endsection