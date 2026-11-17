<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount(['posts' => function ($query) {
            $query->where('status', 'publicado');
        }])->orderBy('name')->get();

        $query = Post::with('category')
            ->where('status', 'publicado');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('content', 'ilike', "%{$search}%")
                  ->orWhere('authors', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $slug = $request->input('category');
            $query->whereHas('category', function ($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        $posts = $query->orderByDesc('activity_date')
            ->orderByDesc('created_at')
            ->paginate(9)
            ->withQueryString();

        return view('blog.index', compact('posts', 'categories'));
    }

    public function show(Post $post)
    {
        if ($post->status !== 'publicado') {
            abort(404);
        }

        $post->load(['category', 'images']);

        return view('blog.show', compact('post'));
    }
}