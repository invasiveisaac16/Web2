<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $post->title }} - Web2</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <div class="min-h-screen">
        
        <nav class="bg-white dark:bg-gray-800 shadow mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="text-lg font-bold text-gray-800 dark:text-white hover:text-blue-500">
                            &larr; Volver al Blog
                        </a>
                    </div>
                    <div class="flex items-center">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900">Log in</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            
            <article class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden mb-10">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm font-bold rounded-full dark:bg-indigo-900 dark:text-indigo-200">
                            {{ $post->category->name ?? 'General' }}
                        </span>
                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                            {{ $post->created_at->format('d F, Y') }}
                        </span>
                    </div>

                    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-6">
                        {{ $post->title }}
                    </h1>

                    <div class="flex items-center mb-8 border-b border-gray-200 dark:border-gray-700 pb-6">
                        <div class="text-sm">
                            <p class="text-gray-900 dark:text-white font-semibold">
                                Por {{ $post->user->name ?? 'Anónimo' }}
                            </p>
                        </div>
                    </div>

                    <div class="prose dark:prose-invert max-w-none text-gray-800 dark:text-gray-300 leading-relaxed">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>
            </article>

            <section class="mt-10">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                    Comentarios ({{ $post->comments->count() }})
                </h3>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="mb-10 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    @auth
                        <form action="{{ route('comments.store', $post) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="content" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                    Escribe un comentario:
                                </label>
                                <textarea 
                                    name="content" 
                                    id="content" 
                                    rows="3" 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-800 dark:text-white dark:border-gray-600"
                                    placeholder="Comparte tu opinión..."
                                    required></textarea>
                                @error('content')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                                    Publicar Comentario
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center">
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Debes iniciar sesión para comentar.</p>
                            <a href="{{ route('login') }}" class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Iniciar Sesión
                            </a>
                        </div>
                    @endauth
                </div>

                <div class="space-y-6">
                    @forelse ($post->comments as $comment)
                        <div class="flex space-x-4 p-6 bg-white dark:bg-gray-800 shadow rounded-lg border-l-4 border-blue-500">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-bold text-gray-900 dark:text-white">
                                        {{ $comment->user->name ?? 'Usuario Eliminado' }}
                                    </h4>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-gray-700 dark:text-gray-300">
                                    {{ $comment->content }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 italic text-center py-4">
                            Nadie ha comentado aún. ¡Sé el primero!
                        </p>
                    @endforelse
                </div>
            </section>

        </main>
    </div>
</body>
</html>