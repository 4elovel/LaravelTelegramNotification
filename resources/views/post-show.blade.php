<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">{{ $post->title }}</h1>
                <div>
                    {{ $post->content }}
                </div>
                <a href="{{ route('posts.index') }}" class="text-blue-500 hover:underline mt-6 block">
                    Back to All Posts
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
