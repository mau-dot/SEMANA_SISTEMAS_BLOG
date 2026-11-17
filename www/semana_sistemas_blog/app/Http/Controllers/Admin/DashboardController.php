<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPosts = Post::count();
        $publishedPosts = Post::where('status', 'publicado')->count();
        $draftPosts = Post::where('status', 'borrador')->count();
        $totalCategories = Category::count();
        $recentPosts = Post::with('category')->latest('activity_date')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPosts',
            'publishedPosts',
            'draftPosts',
            'totalCategories',
            'recentPosts'
        ));
    }
}