@extends('admin.layout')

@section('title', 'Categories - Leonce Admin')

@section('admin-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Categories</h1>
</div>

<div class="flex gap-6">
    <!-- Add New Category -->
    <div class="w-80 shrink-0">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-bold text-gray-900 mb-4">Add Category</h2>
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"
                            placeholder="Category name...">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"
                            placeholder="Optional description...">{{ old('description') }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-brand-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-brand-700 transition">
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories List -->
    <div class="flex-1">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="text-left px-5 py-3 font-medium text-gray-500">Name</th>
                            <th class="text-left px-5 py-3 font-medium text-gray-500">Slug</th>
                            <th class="text-left px-5 py-3 font-medium text-gray-500">Description</th>
                            <th class="text-left px-5 py-3 font-medium text-gray-500">Posts</th>
                            <th class="text-right px-5 py-3 font-medium text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $index => $category)
                        <tr class="border-b border-gray-50 {{ $index % 2 === 0 ? 'bg-white' : 'bg-slate-50/50' }} hover:bg-brand-50/30 transition">
                            <td class="px-5 py-3 font-medium text-gray-900">{{ $category->name }}</td>
                            <td class="px-5 py-3 text-gray-400 font-mono text-xs">{{ $category->slug }}</td>
                            <td class="px-5 py-3 text-gray-500 max-w-xs truncate">{{ $category->description ?: '—' }}</td>
                            <td class="px-5 py-3">
                                <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2 py-0.5 rounded-full">{{ $category->posts_count }}</span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="text-gray-400 hover:text-brand-600 transition" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-gray-400 hover:text-brand-600 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category? Posts in it will be unassigned.')">
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
                            <td colspan="5" class="px-5 py-12 text-center text-gray-400">No categories yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
