<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web2 - Blog</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    
    <div class="relative min-h-screen selection:bg-red-500 selection:text-white">

        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10 w-full bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <main class="max-w-7xl mx-auto p-6 lg:p-8 mt-16">
            
            <div class="flex justify-center mb-12">
               <h1 class="text-4xl font-bold text-gray-800 dark:text-white">Web2 Blog Público</h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @forelse ($posts as $post)
                    <article class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 border border-gray-200 dark:border-gray-700">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full dark:bg-blue-900 dark:text-blue-200">
                                    {{ $post->category->name ?? 'General' }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $post->created_at->format('d M, Y') }}
                                </span>
                            </div>

                            <h2 class="text-xl font-bold mb-2 text-gray-800 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                {{-- En el futuro, esto enlazará al detalle del post --}}
                                <a href="{{ route('blog.show', $post) }}">
    {{ $post->title }}
</a>
                            </h2>

                            <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                                {{ $post->content }}
                            </p>

                            <div class="flex items-center mt-4 border-t pt-4 dark:border-gray-700">
                                <div class="text-sm">
                                    <p class="text-gray-900 dark:text-white font-semibold leading-none">
                                        {{ $post->user->name ?? 'Usuario Desconocido' }}
                                    </p>
                                    <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">Autor</p>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 text-center py-12">
                        <p class="text-gray-500 text-lg">Aún no hay publicaciones disponibles.</p>
                    </div>
                @endforelse

            </div>
        </main>

        <footer class="text-center py-8 text-sm text-gray-500 dark:text-gray-400">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
    </div>
</body>
</html>