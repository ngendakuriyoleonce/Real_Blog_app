@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="px-4 sm:px-0">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Categories</h1>

    @if ($categories->count())
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($categories as $category)
                <a href="{{ route('categories.show', $category) }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2 hover:text-brand-600">
                        {{ $category->name }}
                    </h2>
                    <p class="text-gray-600 text-sm mb-4">{{ $category->description ?? 'No description' }}</p>
                    <span class="text-sm text-gray-500">{{ $category->posts_count }} {{ Str::plural('post', $category->posts_count) }}</span>
                </a>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">No categories yet.</p>
    @endif
</div>
@endsection
