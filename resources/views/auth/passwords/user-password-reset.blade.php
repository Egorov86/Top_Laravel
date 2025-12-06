@extends('layouts.app')
@section('content')
    <form method="POST" action="{{ route('change.password', $user->id) }}">
        @csrf

        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Пароль</label>
            <input type="password" name="password" id="password"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required minlength="6">
            <p class="text-gray-500 text-xs mt-1">Минимум 6 символов</p>
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Подтверждение
                пароля</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required minlength="6">
        </div>

        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Сменить пароль
        </button>
    </form>
@endsection
