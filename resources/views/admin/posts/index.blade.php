@extends('admin.layout')

@section('title', 'Posts - Leonce Admin')

@section('admin-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Posts</h1>
    <a href="{{ route('admin.posts.create') }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-brand-700 transition">
        + Add New Post
    </a>
</div>

<!-- Filter Bar -->
<form method="GET" action="{{ route('admin.posts.index') }}" class="bg-white rounded-xl border border-gray-200 p-4 mb-6">
    <div class="flex flex-wrap items-end gap-3">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title..."
                class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 bg-gray-50 focus:bg-white focus:border-brand-400 focus:ring-1 focus:ring-brand-400 transition">
        </div>
        <div class="min-w-[180px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">Category</label>
            <select name="category_id" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 bg-gray-50 focus:bg-white focus:border-brand-400 focus:ring-1 focus:ring-brand-400 transition">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }} ({{ $category->posts_count }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[150px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
            <select name="status" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 bg-gray-50 focus:bg-white focus:border-brand-400 focus:ring-1 focus:ring-brand-400 transition">
                <option value="">All Statuses</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-brand-700 transition">
                Apply Filters
            </button>
            @if (request()->hasAny(['search', 'category_id', 'status']))
                <a href="{{ route('admin.posts.index') }}" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                    Clear
                </a>
            @endif
        </div>
    </div>
    @if (request()->hasAny(['search', 'category_id', 'status']))
        <div class="mt-3 text-sm text-gray-500">
            Showing {{ $posts->total() }} post{{ $posts->total() !== 1 ? 's' : '' }}
            @if (request('category_id'))
                in <span class="font-medium text-gray-700">{{ $categories->firstWhere('id', request('category_id'))?->name }}</span>
            @endif
            @if (request('status'))
                with status <span class="font-medium text-gray-700">{{ ucfirst(request('status')) }}</span>
            @endif
        </div>
    @endif
</form>

<!-- Posts Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Title</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Category</th>
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
                        <div class="flex items-center gap-3">
                            @if ($post->image)
                                <img src="{{ asset('postimage/' . $post->image) }}" alt="" class="w-10 h-10 rounded-lg object-cover shrink-0">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <a href="{{ route('admin.posts.edit', $post) }}" class="font-medium text-gray-900 hover:text-brand-600 transition line-clamp-1">
                                {{ $post->title }}
                            </a>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <span class="text-gray-600">{{ $post->category->name }}</span>
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
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-gray-400 hover:text-brand-600 transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-gray-400">No posts found.</td>
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
