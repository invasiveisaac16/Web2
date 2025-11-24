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
        $posts = Post::with(['user', 'category'])
            ->latest()
            ->when(request('search'), function($query) {
                $query->where('title', 'like', '%' . request('search') . '%')
                      ->orWhere('content', 'like', '%' . request('search') . '%');
            })
            ->paginate(9)
            ->withQueryString();

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
