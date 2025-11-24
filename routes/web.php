<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
#cambio
use App\Models\Post;
use App\Http\Controllers\CommentController;

use App\Http\Controllers\BlogController;

Route::get('/', [BlogController::class, 'index'])->name('home');

// Ruta para ver un post individual (Pública)
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');

// ... rutas auth ...

Route::get('/dashboard', function () {
    return view('dashboard', [
        'postsCount' => \App\Models\Post::count(),
        'categoriesCount' => \App\Models\Category::count(),
        'commentsCount' => \App\Models\Comment::count(),
        'recentPosts' => \App\Models\Post::latest()->take(5)->get()
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostController::class);
    Route::post('/blog/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
});

require __DIR__.'/auth.php';
