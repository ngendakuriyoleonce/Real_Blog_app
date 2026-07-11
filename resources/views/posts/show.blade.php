@extends('layouts.app')

@section('title', $post->title)

@section('content')
<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <header class="mb-10">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('home', ['category' => $post->category->slug]) }}" class="inline-block bg-brand-100 text-brand-700 text-xs font-semibold px-3 py-1 rounded-full hover:bg-brand-200 transition">
                {{ $post->category->name }}
            </a>
            <span class="text-sm text-gray-400">{{ $post->published_at->format('M d, Y') }}</span>
            <span class="text-sm text-gray-400">·</span>
            <span class="text-sm text-gray-400">{{ $post->reading_time }} min read</span>
        </div>
        <h1 class="font-editorial text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">{{ $post->title }}</h1>
        <div class="flex items-center gap-3 text-sm text-gray-500">
            <div class="w-9 h-9 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 font-bold text-sm">
                {{ substr($post->user->name, 0, 1) }}
            </div>
            <span class="font-medium text-gray-700">{{ $post->user->name }}</span>
        </div>
    </header>

    @if ($post->image)
    <div class="mb-10 -mx-4 sm:mx-0">
        <img src="{{ asset('postimage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-auto max-h-[480px] object-cover rounded-xl">
    </div>
    @endif

    <div class="prose prose-lg max-w-none mb-12 text-gray-700 leading-relaxed">
        {!! nl2br(e($post->content)) !!}
    </div>

    <section class="border-t border-gray-200 pt-8">
        <h2 class="font-editorial text-2xl font-bold text-gray-900 mb-6">Comments ({{ $post->comments->count() }})</h2>

        @auth
            <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-8">
                @csrf
                <textarea name="body" rows="3" required
                    class="w-full rounded-lg border-gray-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm"
                    placeholder="Write a comment..."></textarea>
                <button type="submit" class="mt-2 bg-brand-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-brand-700 transition">
                    Post Comment
                </button>
            </form>
        @else
            <p class="text-gray-500 mb-8 text-sm"><a href="/login" class="text-brand-600 hover:text-brand-700 font-medium hover:underline">Login</a> to leave a comment.</p>
        @endauth

        @foreach ($post->comments->whereNull('parent_id') as $comment)
            <div class="mb-6 bg-stone-50 rounded-lg p-4 border border-gray-100">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-medium text-gray-900 text-sm">{{ $comment->user->name }}</span>
                    <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-gray-700 text-sm">{{ $comment->body }}</p>

                @foreach ($comment->replies as $reply)
                    <div class="ml-8 mt-4 bg-white rounded-lg p-4 border border-gray-100">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-medium text-gray-900 text-sm">{{ $reply->user->name }}</span>
                            <span class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700 text-sm">{{ $reply->body }}</p>
                    </div>
                @endforeach
            </div>
        @endforeach
    </section>
</article>
@endsection
