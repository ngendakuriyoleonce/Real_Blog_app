@extends('admin.layout')

@section('title', 'Edit Post - Leonce Admin')

@section('admin-content')
<div class="max-w-4xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Post</h1>
        <a href="{{ route('admin.posts.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium transition">&larr; Back to Posts</a>
    </div>

    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 text-sm text-red-700">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="flex gap-6">
            <!-- Main Editor -->
            <div class="flex-1 space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-gray-900 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"
                        placeholder="Enter post title...">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label>
                    <textarea name="excerpt" rows="2"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-gray-900 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"
                        placeholder="Brief summary (optional)">{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                    <textarea name="content" rows="16" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-gray-900 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition font-mono text-sm leading-relaxed"
                        placeholder="Write your post content...">{{ old('content', $post->content) }}</textarea>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="w-72 shrink-0 space-y-5">
                <!-- Publish -->
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h3 class="font-bold text-gray-900 mb-4">Publish</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                            <select name="status" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                                <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Publish Date</label>
                            <input type="datetime-local" name="published_at"
                                value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
                                class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                        </div>
                        <button type="submit" class="w-full bg-brand-600 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-brand-700 transition">
                            Update Post
                        </button>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h3 class="font-bold text-gray-900 mb-4">Featured Image</h3>
                    <div>
                        <input type="file" name="image" accept="image/*" id="image-upload"
                            class="hidden" onchange="previewImage(this)">
                        <label for="image-upload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-200 rounded-lg cursor-pointer hover:border-brand-400 transition">
                            <svg class="w-8 h-8 text-gray-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-xs text-gray-400">Click to replace image</span>
                        </label>
                        @if ($post->image)
                        <div id="image-preview" class="mt-2">
                            <img src="{{ asset('postimage/' . $post->image) }}" alt="Current image" class="w-full h-32 object-cover rounded-lg">
                            <p class="text-xs text-gray-400 mt-1">Current image. Upload new to replace.</p>
                        </div>
                        @else
                        <div id="image-preview" class="mt-2 hidden">
                            <img src="" alt="Preview" class="w-full h-32 object-cover rounded-lg">
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Primary Category -->
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h3 class="font-bold text-gray-900 mb-4">Primary Category</h3>
                    <select name="category_id" required class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                        <option value="">Select category...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Additional Categories -->
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h3 class="font-bold text-gray-900 mb-4">Additional Categories</h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @php
                            $attachedIds = old('category_ids', $post->categories->pluck('id')->toArray());
                        @endphp
                        @foreach ($categories as $category)
                        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer hover:text-brand-600 transition">
                            <input type="checkbox" name="category_ids[]" value="{{ $category->id }}"
                                {{ in_array($category->id, $attachedIds) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                            {{ $category->name }}
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Delete -->
    <div class="bg-white rounded-xl border border-red-200 p-5 mt-6">
        <h3 class="font-bold text-red-700 mb-2">Danger Zone</h3>
        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Are you sure you want to delete this post?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition">
                Delete Post
            </button>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
