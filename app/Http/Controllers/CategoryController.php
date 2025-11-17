<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Obtiene todas las categorías de la BD
        $categories = Category::all();

        // 2. Envía esas categorías a una nueva vista
        return view('categories.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación (¡Nunca confíes en el usuario!)
        // Asegúrate de que el campo 'name' exista, sea texto y tenga max 255 caracteres.
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // 2. Creación
        // Si la validación pasa, crea la nueva categoría.
        $category = new Category();
        $category->name = $request->input('name');
        $category->save();

        // 3. Redirección
        // Devuelve al usuario a la página de la lista con un mensaje de éxito.
        return redirect()->route('categories.index')
                        ->with('success', '¡Categoría creada exitosamente!');
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
    public function edit(Category $category)
    {
        
        return view('categories.edit', [
            'category' => $category
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // 1. Validación (igual que en 'store')
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // 2. Actualización
        // (Laravel ya encontró la categoría por nosotros)
        $category->name = $request->input('name');
        $category->save();

        // 3. Redirección
        return redirect()->route('categories.index')
                        ->with('success', '¡Categoría actualizada exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // 1. Borrado
        // (Laravel ya encontró la categoría)
        $category->delete();

        // 2. Redirección
        return redirect()->route('categories.index')
                        ->with('success', '¡Categoría eliminada exitosamente!');
    }
}
