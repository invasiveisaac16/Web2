@props(['post'])

<article {{ $attributes->merge(['class' => 'relative group bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col h-full animate-slide-up']) }}>
    <div class="h-48 overflow-hidden relative">
        @if($post->image_path)
            <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
        @else
            <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 transform group-hover:scale-110 transition-transform duration-500"></div>
        @endif
        <div class="absolute top-4 left-4"></div>
    </div>
    
    <div class="p-6 flex-grow flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-primary-50 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300">
                {{ $post->category->name ?? 'General' }}
            </span>
            <time class="text-xs text-gray-500 dark:text-gray-400">
                {{ $post->created_at->format('M d, Y') }}
            </time>
        </div>

        <h2 class="text-xl font-bold mb-3 text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
            <a href="{{ route('blog.show', $post) }}" class="focus:outline-none">
                <span class="absolute inset-0"></span>
                {{ $post->title }}
            </a>
        </h2>

        <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3 mb-4 flex-grow">
            {{ $post->content }}
        </p>

        <div class="flex items-center pt-4 border-t border-gray-100 dark:border-gray-700 mt-auto">
            <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-primary-400 to-secondary-400 flex items-center justify-center text-white text-xs font-bold">
                {{ substr($post->user->name ?? 'U', 0, 1) }}
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900 dark:text-white">
                    {{ $post->user->name ?? 'Usuario' }}
                </p>
            </div>
        </div>
    </div>
</article>
