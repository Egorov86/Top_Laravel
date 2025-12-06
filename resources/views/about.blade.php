@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
    <h1 class="text-3xl font-bold mb-6">О нас</h1>
    
    <div class="prose max-w-none">
        <p class="text-gray-700 mb-4">
            Добро пожаловать в наш блог-проект! Это платформа для общения и обмена мыслями.
        </p>
        
        <h2 class="text-2xl font-semibold mt-6 mb-4">Возможности</h2>
        <ul class="list-disc list-inside space-y-2 text-gray-700">
            <li>Создание и публикация постов</li>
            <li>Просмотр постов других пользователей</li>
            <li>Редактирование профиля</li>
            <li>Система авторизации и регистрации</li>
        </ul>

        <h2 class="text-2xl font-semibold mt-6 mb-4">Технологии</h2>
        <p class="text-gray-700">
            Проект разработан на Laravel с использованием Tailwind CSS и SQLite базы данных.
        </p>
    </div>
</div>
@endsection