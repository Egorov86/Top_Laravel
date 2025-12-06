<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Добро пожаловать в Blog Project</h1>
            <p class="text-gray-600 mb-8">Пожалуйста, войдите или зарегистрируйтесь</p>
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">Войти</a>
                <a href="{{ route('register') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">Зарегистрироваться</a>
            </div>
        </div>
    </div>
</body>
</html>