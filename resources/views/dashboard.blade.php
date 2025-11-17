<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-semibold text-xl">Panel de Administración</h2>
                    <ul class="mt-4">
                        <li>
                            <a href="{{ route('categories.index') }}" class="text-blue-500 hover:underline">
                                Gestionar Categorías
                            </a>
                        </li>
                        <li> <a href="{{ route('posts.index') }}" class="text-blue-500 hover:underline">
                                Gestionar Posts
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
