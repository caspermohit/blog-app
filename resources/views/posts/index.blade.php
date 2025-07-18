<x-app-layout>
    <div class="py-12">
          
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class ="text-gray-900 dark:text-gray-100 text-xl font-semibold leading-tight">
                    {{ __('Posts') }}</h1>
                <div class="p-6 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    @foreach ($posts as $post)
                    <div class="mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                            {{ $post->title }}
                        </h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500 dark:text-gray-400">
                            {{ $post->content }}
                        </p>
                        @can('update', $post)
<a href="/posts/{{ $post->id }}/edit" class="w-full flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
Edit</a>
@endcan
<br>
@can('delete', $post)
<form method="POST" action="{{ route('posts.destroy', $post) }}">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-danger w-full flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-700 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
Delete</button>
</form>
@endcan


</div>
                    @endforeach

                    <a href="/posts/create" class="w-full flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"> Create Post</a> 
                </div>
            </div>
        </div>
    </div>              

</x-app-layout>

        