<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CommentController extends Controller
{
    // ── Public ─────────────────────────────────────────────

    public function store(Post $post, StoreCommentRequest $request): RedirectResponse
    {
        $post->comments()->create([
            ...$request->validated(),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Comment added successfully.');
    }

    public function destroy(Post $post, Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()->route('posts.show', $post)
            ->with('success', 'Comment deleted successfully.');
    }

    // ── Admin ──────────────────────────────────────────────

    public function adminIndex(Request $request): View
    {
        $query = Comment::with(['user', 'post'])->latest();

        if ($request->filled('search')) {
            $query->where('body', 'like', "%{$request->search}%");
        }

        if ($request->filled('post_id')) {
            $query->where('post_id', $request->post_id);
        }

        $comments = $query->paginate(20)->withQueryString();
        $posts = Post::orderBy('title')->get(['id', 'title']);

        return view('admin.comments.index', compact('comments', 'posts'));
    }

    public function adminDestroy(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()->route('admin.comments.index')->with('success', 'Comment deleted.');
    }
}
