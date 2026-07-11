@extends('admin.layout')

@section('title', 'Edit Category - Leonce Admin')

@section('admin-content')
<div class="max-w-xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-500 hover:text-brand-600 transition">&larr; Categories</a>
            <h1 class="text-2xl font-bold text-gray-900 mt-1">Edit Category</h1>
        </div>
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

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-gray-900 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"
                        placeholder="Category name...">
                    <p class="text-xs text-gray-400 mt-1">Slug will be auto-generated: <span class="font-mono" id="slug-preview">{{ $category->slug }}</span></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-gray-900 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition"
                        placeholder="Optional description...">{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="bg-brand-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-brand-700 transition">
                        Update Category
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium transition">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.querySelector('input[name="name"]').addEventListener('input', function() {
            document.getElementById('slug-preview').textContent = this.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-|-$/g, '');
        });
    </script>
</div>
@endsection
