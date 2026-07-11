<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BlogService
{
    public function getPublishedPosts(
        ?string $search = null,
        ?string $category = null,
        int $perPage = 12
    ): LengthAwarePaginator {
        return Post::published()
            ->with('category', 'user')
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            })
            ->when($category, function ($query, $category) {
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category);
                });
            })
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function getPostBySlug(string $slug): Post
    {
        return Post::where('slug', $slug)
            ->with(['category', 'user', 'comments.user', 'comments.replies.user'])
            ->firstOrFail();
    }

    public function createPost(array $data, int $userId): Post
    {
        return Post::create([
            ...$data,
            'user_id' => $userId,
            'status' => 'draft',
        ]);
    }
}
