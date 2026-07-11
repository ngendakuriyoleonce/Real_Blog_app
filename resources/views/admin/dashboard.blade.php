@extends('admin.layout')

@section('title', 'Dashboard - Leonce Admin')

@section('admin-content')
<h1 class="text-2xl font-bold text-gray-900 mb-6">Dashboard</h1>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-medium text-gray-500">Total Posts</span>
            <span class="w-10 h-10 rounded-lg bg-brand-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </span>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ $stats['total_posts'] }}</div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-medium text-gray-500">Published</span>
            <span class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </span>
        </div>
        <div class="text-3xl font-bold text-emerald-600">{{ $stats['published'] }}</div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-medium text-gray-500">Drafts</span>
            <span class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </span>
        </div>
        <div class="text-3xl font-bold text-amber-600">{{ $stats['drafts'] }}</div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-medium text-gray-500">Categories</span>
            <span class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
            </span>
        </div>
        <div class="text-3xl font-bold text-purple-600">{{ $stats['total_categories'] }}</div>
    </div>
</div>

<!-- Recent Posts -->
<div class="bg-white rounded-xl border border-gray-200">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-bold text-gray-900">Recent Posts</h2>
        <a href="{{ route('admin.posts.create') }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-brand-700 transition">
            + New Post
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Title</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Category</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Author</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Status</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentPosts as $post)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="px-5 py-3">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="font-medium text-gray-900 hover:text-brand-600 transition">
                            {{ Str::limit($post->title, 40) }}
                        </a>
                    </td>
                    <td class="px-5 py-3 text-gray-500">{{ $post->category->name }}</td>
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
                    <td class="px-5 py-3 text-gray-400">{{ $post->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-8 text-center text-gray-400">No posts yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
