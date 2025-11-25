<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = request('page', 1);
        $search = request('search', '');
        
        $posts = \Illuminate\Support\Facades\Cache::remember("posts_index_{$page}_{$search}", 60, function () {
            return Post::with(['user', 'category'])
                ->latest()
                ->filter(request(['search']))
                ->paginate(9)
                ->withQueryString();
        });

        return view('welcome', [
            'posts' => $posts
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Optimization: Load relationships to avoid N+1 problem
        $post->load(['user', 'category', 'comments.user']);

        return view('post-show', [
            'post' => $post
        ]);
    }
}
