
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Posts') }}
        </h2>
    </x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="mb-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ __('Posts') }}
                    </h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Here are all the posts') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($posts as $post)
                        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-md flex flex-col">
                            <!-- Image -->
                           <div class="mt-4 h-40 w-full flex items-center justify-center bg-white dark:bg-gray-900 rounded-lg">
                                 <img src="{{ asset('storage/' . $post->file) }}" alt="Post Image" 
                                 class="max-h-full max-w-full object-contain rounded-md shadow">
                                </div>

                            <!-- Content -->
                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white break-words">
                                        {{ $post->title }}
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-4 break-words">
                                        {{ $post->content }}
                                    </p>
                                </div>
                                <div class="mt-4 flex justify-between space-x-2">
                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                        {{ $post->created_at->format('d/m/Y') }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                       posted by {{ $post->user->name }}
                                    </p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-4 flex justify-between space-x-2">
                                    @can('update', $post)
                                        <a href="/posts/{{ $post->id }}/edit"
                                           class="w-full inline-flex justify-center items-center px-3 py-2 text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                            Edit
                                        </a>
                                    @endcan

                                    @can('delete', $post)
                                        <form method="POST" action="{{ route('posts.destroy', $post) }}" class="w-full">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this post?')"
                                                    class="w-full inline-flex justify-center items-center px-3 py-2 text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Create Post Button -->
                <div class="mt-10 text-center">
                    <a href="/posts/create"
                       class="inline-flex items-center px-5 py-3 text-sm font-semibold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        + Create New Post
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>