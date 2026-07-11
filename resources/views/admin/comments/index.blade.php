@extends('admin.layout')

@section('title', 'Comments - Leonce Admin')

@section('admin-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Comments</h1>
</div>

<!-- Filter Bar -->
<form method="GET" action="{{ route('admin.comments.index') }}" class="bg-white rounded-xl border border-gray-200 p-4 mb-6">
    <div class="flex flex-wrap items-end gap-3">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search comments..."
                class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 bg-gray-50 focus:bg-white focus:border-brand-400 focus:ring-1 focus:ring-brand-400 transition">
        </div>
        <div class="min-w-[200px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">Post</label>
            <select name="post_id" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 bg-gray-50 focus:bg-white focus:border-brand-400 focus:ring-1 focus:ring-brand-400 transition">
                <option value="">All Posts</option>
                @foreach ($posts as $post)
                    <option value="{{ $post->id }}" {{ request('post_id') == $post->id ? 'selected' : '' }}>
                        {{ Str::limit($post->title, 40) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-brand-700 transition">
                Apply Filters
            </button>
            @if (request()->hasAny(['search', 'post_id']))
                <a href="{{ route('admin.comments.index') }}" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                    Clear
                </a>
            @endif
        </div>
    </div>
</form>

<!-- Comments Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Author</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Comment</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Post</th>
                    <th class="text-left px-5 py-3 font-medium text-gray-500">Date</th>
                    <th class="text-right px-5 py-3 font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($comments as $index => $comment)
                <tr class="border-b border-gray-50 {{ $index % 2 === 0 ? 'bg-white' : 'bg-slate-50/50' }} hover:bg-brand-50/30 transition">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 font-bold text-xs shrink-0">
                                {{ substr($comment->user->name, 0, 1) }}
                            </div>
                            <span class="font-medium text-gray-900 text-sm">{{ $comment->user->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-gray-600 max-w-sm">
                        <p class="line-clamp-2">{{ $comment->body }}</p>
                    </td>
                    <td class="px-5 py-3">
                        <a href="{{ route('admin.posts.edit', $comment->post) }}" class="text-brand-600 hover:text-brand-700 text-sm transition line-clamp-1 max-w-[180px] block">
                            {{ Str::limit($comment->post->title, 30) }}
                        </a>
                    </td>
                    <td class="px-5 py-3 text-gray-400 whitespace-nowrap">{{ $comment->created_at->format('M d, Y') }}</td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('posts.show', $comment->post) }}" target="_blank" class="text-gray-400 hover:text-brand-600 transition" title="View on site">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" onsubmit="return confirm('Delete this comment?')">
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
                    <td colspan="5" class="px-5 py-12 text-center text-gray-400">No comments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($comments->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $comments->links() }}
    </div>
    @endif
</div>
@endsection
