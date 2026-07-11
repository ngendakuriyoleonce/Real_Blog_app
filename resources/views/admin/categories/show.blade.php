@extends('admin.layout')

@section('title', $category->name . ' - Leonce Admin')

@section('admin-content')
<div class="flex items-center justify-between mb-6">
    <div>
        <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-500 hover:text-brand-600 transition">&larr; Categories</a>
        <h1 class="text-2xl font-bold text-gray-900 mt-1">{{ $category->name }}</h1>
        @if ($category->description)
            <p class="text-gray-500 mt-1">{{ $category->description }}</p>
        @endif
    </div>
    <a href="{{ route('admin.categories.edit', $category) }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-brand-700 transition">
        Edit Category
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <span class="text-sm font-medium text-gray-500">Total Posts</span>
        <div class="text-3xl font-bold text-gray-900 mt-1">{{ $category->posts_count }}</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <span class="text-sm font-medium text-gray-500">Slug</span>
        <div class="text-lg font-mono text-gray-600 mt-1">{{ $category->slug }}</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <span class="text-sm font-medium text-gray-500">Created</span>
        <div class="text-lg text-gray-900 mt-1">{{ $category->created_at->format('M d, Y') }}</div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100">
        <h2 class="font-bold text-gray-900">Posts in this Category</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Title</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Author</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Status</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Date</th>
                    <th class="text-right px-5 py-3 font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $index => $post)
                <tr class="border-b border-gray-50 {{ $index % 2 === 0 ? 'bg-white' : 'bg-slate-50/50' }} hover:bg-brand-50/30 transition">
                    <td class="px-5 py-3">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="font-medium text-gray-900 hover:text-brand-600 transition line-clamp-1">
                            {{ $post->title }}
                        </a>
                    </td>
                    <td class="px-5 py-3 text-gray-500">{{ $post->user->name }}</td>
                    <td class="px-5 py-3">
                        @if ($post->status === 'published')
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Published
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> Draft
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-gray-400 whitespace-nowrap">{{ $post->created_at->format('M d, Y') }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-gray-400 hover:text-brand-600 transition" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center text-gray-400">No posts in this category.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($posts->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $posts->links() }}
    </div>
    @endif
</div>
@endsection
