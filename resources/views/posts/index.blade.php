<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 text-center">
                            {{ __('Posts') }}
                        </h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500 dark:text-gray-400 text-center">
                            {{ __('Here are all the posts') }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($posts as $post)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow h-64">
                                <div class="flex flex-col space-y-3 h-full">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 break-words">
                                            {{ $post->title }}
                                        </h3>
                                        <div class="mt-2 max-h-32 overflow-y-auto">
                                            <p class="text-sm text-gray-600 dark:text-gray-400 break-words">
                                                {{ $post->content }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        @can('update', $post)
                                            <a href="/posts/{{ $post->id }}/edit" 
                                               class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                                                Edit
                                            </a>
                                        @endcan
                                        
                                        @can('delete', $post)
                                            <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                                                        onclick="return confirm('Are you sure you want to delete this post?')">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 text-center">
                        <a href="/posts/create" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            Create Post
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
