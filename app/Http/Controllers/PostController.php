<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;       
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Obtiene los posts
        $query = Post::with('category', 'user')->latest();

        // Si NO es admin, solo ve sus propios posts
        if (!Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        $posts = $query->get();

        // 2. Envía los posts a la nueva vista
        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 1. Obtiene todas las categorías de la BD
        $categories = Category::all();

        // 2. Envía las categorías a la nueva vista del formulario
        return view('posts.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación (Reglas para cada campo)
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 2. Creación del Post
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');
        $post->user_id = Auth::id();

        // Manejo de la imagen
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image_path = $imagePath;
        } 

        $post->save();

        // Clear Cache
        \Illuminate\Support\Facades\Cache::forget('dashboard_stats');

        // 3. Redirección
        return redirect()->route('posts.index')
                        ->with('success', '¡Post creado exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $post);

        // 1. Obtiene todas las categorías (para el dropdown)
        $categories = Category::all();

        // 2. Envía el post y las categorías a la vista
        return view('posts.edit', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $post);

        // 1. Validación (igual que en 'store')
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 2. Actualización
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');

        // Manejo de la imagen
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior si existe
            if ($post->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($post->image_path);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image_path = $imagePath;
        }

        $post->save();

        // Clear Cache
        \Illuminate\Support\Facades\Cache::forget('dashboard_stats');

        // 3. Redirección
        return redirect()->route('posts.index')
                        ->with('success', '¡Post actualizado exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        \Illuminate\Support\Facades\Gate::authorize('delete', $post);

        // 1. Borrado
        if ($post->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($post->image_path);
        }
        $post->delete();

        // Clear Cache
        \Illuminate\Support\Facades\Cache::forget('dashboard_stats');

        // 2. Redirección
        return redirect()->route('posts.index')
                        ->with('success', '¡Post eliminado exitosamente!');
    }
}
