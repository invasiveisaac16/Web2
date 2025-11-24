<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Web2') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 selection:bg-primary-500 selection:text-white">
    
    <!-- Navigation Overlay -->
    @if (Route::has('login'))
        <div class="fixed top-0 right-0 p-6 text-right z-50">
            @auth
                <a href="{{ url('/dashboard') }}" class="font-medium text-gray-600 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white transition-colors">Gestión</a>
            @else
                <a href="{{ route('login') }}" class="font-medium text-gray-600 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white transition-colors">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 font-medium text-gray-600 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white transition-colors">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="min-h-screen flex flex-col">
        <!-- Hero Section -->
        <header class="relative pt-32 pb-20 px-6 text-center overflow-hidden">
            <div class="absolute inset-0 -z-10 opacity-30 blur-3xl bg-gradient-to-tr from-primary-200 to-secondary-200 dark:from-primary-900 dark:to-secondary-900 animate-pulse-slow"></div>
            
            <h1 class="text-5xl md:text-7xl font-bold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-600 dark:from-primary-400 dark:to-secondary-400 animate-fade-in">
                SuperBlog
            </h1>
            <p class="mt-6 text-lg md:text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto animate-slide-up" style="animation-delay: 0.1s;">
                Explora ideas, tutoriales y noticias sobre el desarrollo web moderno.
            </p>
        <!-- Search Form -->
            <div class="mt-8 max-w-md mx-auto animate-slide-up" style="animation-delay: 0.2s;">
                <form action="{{ route('home') }}" method="GET" class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Buscar artículos..." 
                           class="w-full px-5 py-3 rounded-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent shadow-sm transition-all"
                    >
                    <button type="submit" class="absolute right-2 top-1.5 p-1.5 bg-primary-600 text-white rounded-full hover:bg-primary-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow max-w-7xl mx-auto px-6 lg:px-8 w-full pb-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @forelse ($posts as $post)
                    <x-post-card :post="$post" style="animation-delay: {{ $loop->iteration * 0.1 }}s;" />
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">No se encontraron publicaciones</h3>
                        <p class="mt-1 text-gray-500 dark:text-gray-400">Intenta con otra búsqueda o vuelve más tarde.</p>
                        @if(request('search'))
                            <a href="{{ route('home') }}" class="mt-4 inline-block text-primary-600 hover:underline">Ver todos los posts</a>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </main>

        <footer class="py-8 text-center text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-800">
            <p>&copy; {{ date('Y') }} Web2 Blog. Construido con Laravel & Tailwind.</p>
        </footer>
    </div>
</body>
</html>