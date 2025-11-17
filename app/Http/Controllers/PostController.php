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
        // 1. Obtiene todos los posts (los más nuevos primero)
        //    'with' carga también la info de la categoría y el autor para no hacer mil consultas
        $posts = Post::with('category', 'user')->latest()->get();

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
            'category_id' => 'required|integer|exists:categories,id', // 'exists' asegura que la categoría sea real
            'content' => 'required|string',
        ]);

        // 2. Creación del Post
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');

        // ¡Paso clave! Asigna el ID del usuario que está logueado
        $post->user_id = Auth::id(); 

        $post->save();

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
        // 1. Validación (igual que en 'store')
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'content' => 'required|string',
        ]);

        // 2. Actualización
        // (Laravel ya encontró el post por nosotros)
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');
        // No cambiamos el user_id, el autor original se mantiene
        $post->save();

        // 3. Redirección
        return redirect()->route('posts.index')
                        ->with('success', '¡Post actualizado exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // 1. Borrado
        // (Laravel ya encontró el post)
        $post->delete();

        // 2. Redirección
        return redirect()->route('posts.index')
                        ->with('success', '¡Post eliminado exitosamente!');
    }
}
