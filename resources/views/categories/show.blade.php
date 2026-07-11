@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="px-4 sm:px-0">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
        @if ($category->description)
            <p class="mt-2 text-gray-600">{{ $category->description }}</p>
        @endif
    </div>

    @if ($posts->count())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($posts as $post)
                <article class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6">
                        <div class="text-sm text-gray-500 mb-2">
                            <span>{{ $post->published_at->diffForHumans() }}</span>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">
                            <a href="{{ route('posts.show', $post) }}" class="hover:text-indigo-600">
                                {{ $post->title }}
                            </a>
                        </h2>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($post->excerpt, 100) }}</p>
                        <div class="text-sm text-gray-500">
                            By {{ $post->user->name }}
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @else
        <p class="text-gray-500">No posts in this category yet.</p>
    @endif
</div>
@endsection
