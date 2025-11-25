<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Función para guardar un comentario nuevo
    public function store(Request $request, Post $post)
    {
        // 1. Validar que no envíen comentarios vacíos
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // 2. Crear el comentario usando la relación del Post
        // Laravel asigna automáticamente el post_id gracias a la relación
        $post->comments()->create([
            'content' => $request->content,
            'user_id' => Auth::id(), // Asignamos el ID del usuario conectado
        ]);

        // Clear Cache
        \Illuminate\Support\Facades\Cache::forget('dashboard_stats');

        // 3. Redirigir de vuelta al post con un mensaje de éxito
        return back()->with('success', '¡Comentario publicado correctamente!');
    }
}