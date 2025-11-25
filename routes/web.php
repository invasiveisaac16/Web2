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
    // Data for Charts
    // Data for Charts
    $data = \Illuminate\Support\Facades\Cache::remember('dashboard_stats', 60, function () {
        $postsByCategory = \App\Models\Category::withCount('posts')->get();
        $postsPerDay = \App\Models\Post::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->take(7)
            ->get()
            ->reverse();
            
        return [
            'postsCount' => \App\Models\Post::count(),
            'categoriesCount' => \App\Models\Category::count(),
            'commentsCount' => \App\Models\Comment::count(),
            'recentPosts' => \App\Models\Post::latest()->take(5)->get(),
            'postsByCategory' => $postsByCategory,
            'postsPerDay' => $postsPerDay
        ];
    });

    return view('dashboard', $data);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['admin'])->group(function () {
        Route::resource('categories', CategoryController::class);
    });

    Route::resource('posts', PostController::class);

    Route::post('/blog/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
});

require __DIR__.'/auth.php';
