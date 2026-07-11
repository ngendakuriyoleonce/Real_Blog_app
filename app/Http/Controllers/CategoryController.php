<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    //user section

    public function index(): View
    {
        $categories = Category::withCount('posts')->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category): View
    {
        $posts = $category->posts()
            ->published()
            ->with('user')
            ->latest('published_at')
            ->paginate(12);

        return view('categories.show', compact('category', 'posts'));
    }

    // admin section

    public function adminIndex(): View
    {
        $categories = Category::withCount('posts')->orderBy('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function adminShow(Category $category): View
    {
        $category->loadCount('posts');
        $posts = Post::where('category_id', $category->id)
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('admin.categories.show', compact('category', 'posts'));
    }

    public function adminStore(StoreCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function adminEdit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function adminUpdate(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function adminDestroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }
}
