@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6 text-center">Вход</h2>

    <form method="POST" action="{{ route('post.login') }}">
        @csrf

        <div class="mb-4">
            <label for="login" class="block text-gray-700 text-sm font-bold mb-2">Username или Email</label>
            <input type="text" name="login" id="login" value="{{ old('login') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required autofocus>
        </div>

        <div class="mb-6">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">@lang('messages.password')</label>
            <input type="password" name="password" id="password"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @lang('messages.login')
        </button>
    </form>

    <div class="mt-4 text-center">
        <p class="text-gray-600">Нет аккаунта?
            <a href="{{ route('register', ['lang' => app()->getLocale()]) }}" class="text-blue-600 hover:text-blue-800">Зарегистрироваться</a>
        </p>
        <a href="{{ route('password.reset', ['lang' => app()->getLocale()]) }}" class="text-blue-600 hover:text-blue-800">Забыли пароль?</a>
    </div>
</div>
@endsection
