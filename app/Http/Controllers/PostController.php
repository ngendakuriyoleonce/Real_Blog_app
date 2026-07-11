<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class PostController extends Controller
{
//user section
    public function index(Request $request): View
    {
        $posts = Post::published()
            ->with('category', 'user')
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            })
            ->when($request->category, function ($query, $category) {
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category);
                });
            })
            ->latest('published_at')
            ->paginate(12);

        $categories = Category::withCount('posts')->get();

        $featured = Post::published()
            ->with('category', 'user')
            ->latest('published_at')
            ->first();

        $activeCategory = $request->category;

        return view('posts.index', compact('posts', 'categories', 'featured', 'activeCategory'));
    }

    public function show(Post $post): View
    {
        $post->load(['category', 'user', 'comments.user', 'comments.replies.user']);

        return view('posts.show', compact('post'));
    }

    //admin section

    public function adminDashboard(): View
    {
        $stats = [
            'total_posts' => Post::count(),
            'published' => Post::where('status', 'published')->count(),
            'drafts' => Post::where('status', 'draft')->count(),
            'total_categories' => \App\Models\Category::count(),
            'total_users' => \App\Models\User::count(),
            'total_comments' => \App\Models\Comment::count(),
        ];

        $recentPosts = Post::with('category', 'user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPosts'));
    }

    public function adminIndex(Request $request): View
    {
        $query = Post::with('category', 'user')->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $posts = $query->paginate(15)->withQueryString();
        $categories = Category::withCount('posts')->orderBy('name')->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function adminCreate(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.posts.create', compact('categories'));
    }

    public function adminStore(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('postimage'), $filename);
            $imagePath = $filename;
        }

        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'excerpt' => $validated['excerpt'] ?? null,
            'image' => $imagePath,
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
            'status' => $validated['status'] ?? 'draft',
            'published_at' => ($validated['status'] ?? 'draft') === 'published'
                ? ($validated['published_at'] ?? now())
                : null,
        ]);

        $additionalIds = collect($validated['category_ids'] ?? [])
            ->reject(fn ($id) => $id == $validated['category_id'])
            ->toArray();
        $post->categories()->sync($additionalIds);

        return redirect()->route('admin.posts.index')->with('success', 'Post created.');
    }

    public function adminEdit(Post $post): View
    {
        $categories = Category::orderBy('name')->get();
        $post->load('categories');

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function adminUpdate(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $validated = $request->validated();

        $wasPublished = $post->status === 'published';

        $imagePath = $post->image;
        if ($request->hasFile('image')) {
            if ($post->image && File::exists(public_path('postimage/' . $post->image))) {
                File::delete(public_path('postimage/' . $post->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('postimage'), $filename);
            $imagePath = $filename;
        }

        $post->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'excerpt' => $validated['excerpt'] ?? null,
            'image' => $imagePath,
            'category_id' => $validated['category_id'],
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published' && !$wasPublished
                ? ($validated['published_at'] ?? now())
                : $post->published_at,
        ]);

        $additionalIds = collect($validated['category_ids'] ?? [])
            ->reject(fn ($id) => $id == $validated['category_id'])
            ->toArray();
        $post->categories()->sync($additionalIds);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated.');
    }

    public function adminDestroy(Post $post): RedirectResponse
    {
        if ($post->image && File::exists(public_path('postimage/' . $post->image))) {
            File::delete(public_path('postimage/' . $post->image));
        }
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted.');
    }

    public function adminUsers(): View
    {
        $users = \App\Models\User::withCount('posts')->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }
}
