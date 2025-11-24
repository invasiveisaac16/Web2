<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
#cambio
use App\Models\Post;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    // Obtenemos los posts ordenados por el más reciente
    // 'with' carga la relación de usuario y categoría en UNA sola consulta 
    $posts = Post::with(['user', 'category'])->latest()->get();

    return view('welcome', [
        'posts' => $posts
    ]);
})->name('home');

// Ruta para ver un post individual (Pública)
// Usamos Route Model Binding: Laravel busca el Post automáticamente por su ID
Route::get('/blog/{post}', function (Post $post) {
    
    // OPTIMIZACIÓN CRÍTICA PARA EL PROFESOR:
    // Como el $post ya "llegó" inyectado a la función, usamos ->load() en vez de ::with()
    // Cargamos:
    // 1. 'user' => El autor del post.
    // 2. 'category' => La categoría del post.
    // 3. 'comments.user' => Cargamos los comentarios Y, dentro de ellos, al autor de cada comentario.
    
    $post->load(['user', 'category', 'comments.user']);

    return view('post-show', [
        'post' => $post
    ]);
})->name('blog.show');

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
