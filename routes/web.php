<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    if (Auth::check() && !Auth::user()->is_admin) {
        return redirect()->route('home');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Public routes
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Comment routes
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/posts/{post}/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/', [PostController::class, 'adminDashboard'])->name('dashboard');

    // Posts
    Route::get('/posts', [PostController::class, 'adminIndex'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'adminCreate'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'adminStore'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'adminEdit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'adminUpdate'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'adminDestroy'])->name('posts.destroy');

    // Categories
    Route::get('/categories', [CategoryController::class, 'adminIndex'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'adminStore'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'adminShow'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'adminEdit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'adminUpdate'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'adminDestroy'])->name('categories.destroy');

    // Comments
    Route::get('/comments', [CommentController::class, 'adminIndex'])->name('comments.index');
    Route::delete('/comments/{comment}', [CommentController::class, 'adminDestroy'])->name('comments.destroy');

    // Users
    Route::get('/users', [PostController::class, 'adminUsers'])->name('users.index');
});

require __DIR__.'/auth.php';
