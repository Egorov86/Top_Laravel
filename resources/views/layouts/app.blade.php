<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Левая часть - меню -->
                <div class="flex space-x-4 items-center">
                    <a href="{{ route('posts.index', ['lang' => app()->getLocale()]) }}" class="hover:bg-blue-700 px-3 py-2 rounded transition">@lang('messages.main')</a>
                    <a href="{{ route('posts.index', ['lang' => app()->getLocale()]) }}" class="hover:bg-blue-700 px-3 py-2 rounded transition">Посты</a>

                    <!-- Dropdown Категории -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                                class="hover:bg-blue-700 px-3 py-2 rounded transition flex items-center space-x-1">
                            <span>Категории</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" @click.outside="open = false"
                             class="absolute left-0 mt-2 w-64 bg-white text-black rounded shadow-md z-50">

                            @foreach($globalCategories as $category)
                                <div class="border-b last:border-none" x-data="{ open1: false }">
                                    <!-- 1 уровень -->
                                    <button
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 font-semibold flex justify-between"
                                        @click="open1 = !open1">
                                        {{ $category->name }}
                                        <span x-text="open1 ? '−' : '+'"></span>
                                    </button>

                                    <!-- 2 уровень -->
                                    <div x-show="open1" class="bg-gray-50">
                                        @foreach($category->children as $sub)
                                            <div class="border-b last:border-none px-4" x-data="{ open2: false }">
                                                @if($sub->children->isEmpty())
                                                    <a href="{{ route('category.show', ['lang' => app()->getLocale(), 'category' => $sub->id]) }}"
                                                       class="block px-2 py-2 hover:bg-gray-200 text-sm">
                                                        {{ $sub->name }}
                                                    </a>
                                                @else
                                                    <button
                                                        class="w-full text-left px-2 py-2 hover:bg-gray-200 text-sm flex justify-between"
                                                        @click="open2 = !open2">
                                                        {{ $sub->name }}
                                                        <span x-text="open2 ? '−' : '+'"></span>
                                                    </button>

                                                    <!-- 3 уровень -->
                                                    <div x-show="open2" class="bg-gray-100 ml-4">
                                                        @foreach($sub->children as $subCat)
                                                            <a href="{{ route('category.show', $subCat->id) }}"
                                                               class="block px-2 py-2 hover:bg-gray-200 text-sm">
                                                                {{ $subCat->name }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>


                @if(auth()->check() && auth()->user()->isAdmin())
                        <a href="{{ route('users.index', ['lang' => app()->getLocale()]) }}" class="hover:bg-blue-700 px-3 py-2 rounded transition">Пользователи</a>
                    @endif
                    <a href="{{ route('about', ['lang' => app()->getLocale()]) }}" class="hover:bg-blue-700 px-3 py-2 rounded transition">О нас</a>
                </div>


                <!-- Правая часть - информация пользователя -->
                @auth
                <div class="flex items-center space-x-4">
                    <!-- Аватарка в шапке -->
                    <img src="{{ Auth::user()->getAvatarUrl() }}"
                        alt="{{ Auth::user()->username }}"
                        class="w-8 h-8 rounded-full object-cover">
                    <!-- Имя пользователя -->
                    <span class="text-blue-100">Добро пожаловать, {{ Auth::user()->username }}!</span>

                    <!-- Кнопка Профиль -->
                    <a href="{{ route('profile', ['lang' => app()->getLocale()]) }}"
                        class="bg-blue-500 hover:bg-blue-400 px-4 py-2 rounded transition">
                        Профиль
                    </a>

                    <!-- Кнопка Выйти -->
                    <form method="POST" action="{{ route('logout', ['lang' => app()->getLocale()]) }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-400 px-4 py-2 rounded transition">
                            Выйти
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4">
        <!-- Блок успешных сообщений -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- Блок ошибок -->
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif

        <!-- Блок ошибок валидации -->
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
        @yield('content')
    </main>

</body>

</html>
