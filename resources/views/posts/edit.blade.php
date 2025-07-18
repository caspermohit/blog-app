<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('posts.update', $post) }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $post->id }}">
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Title
                            </label>
                            <div class="mt-1">      
                                <input type="text" name="title" id="title" value="{{ $post->title }}" class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-red-900 dark:text-red-300 border-gray-300 rounded-md">
                            </div>                            
                        </div>

                        @csrf
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Content
                            </label>
                            <div class="mt-1">
                                <textarea name="content" id="content" rows="3" class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-red-900 dark:text-red-300 border-gray-300 rounded-md">{{ $post->content }}</textarea>
                            </div>
                        </div>                          

                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>                                                           
        </div>  
    </x-app-layout>
