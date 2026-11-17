<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'user'])
            ->orderByDesc('activity_date')
            ->get();

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'activity_date' => ['required', 'date'],
            'authors' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:borrador,publicado'],
            'main_image' => ['nullable', 'image', 'max:4096'],
            'evidence_images.*' => ['nullable', 'image', 'max:4096'],
            'evidence_participants.*' => ['nullable', 'string', 'max:150'],
            'evidence_captions.*' => ['nullable', 'string', 'max:255'],
        ]);

        $mainImagePath = null;
        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')->store('posts', 'public');
        }

        $post = Post::create([
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'activity_date' => $validated['activity_date'],
            'authors' => $validated['authors'],
            'content' => $validated['content'],
            'status' => $validated['status'],
            'main_image' => $mainImagePath,
        ]);

        if ($request->hasFile('evidence_images')) {
            foreach ($request->file('evidence_images') as $index => $file) {
                $path = $file->store('evidences', 'public');
                PostImage::create([
                    'post_id' => $post->id,
                    'image_path' => $path,
                    'participant_name' => $request->input("evidence_participants.$index") ?: 'Ambos integrantes',
                    'caption' => $request->input("evidence_captions.$index"),
                ]);
            }
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Entrada registrada correctamente.');
    }

    public function edit(Post $post)
    {
        $post->load('images');
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'activity_date' => ['required', 'date'],
            'authors' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:borrador,publicado'],
            'main_image' => ['nullable', 'image', 'max:4096'],
            'evidence_images.*' => ['nullable', 'image', 'max:4096'],
            'evidence_participants.*' => ['nullable', 'string', 'max:150'],
            'evidence_captions.*' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('main_image')) {
            if ($post->main_image) {
                Storage::disk('public')->delete($post->main_image);
            }
            $post->main_image = $request->file('main_image')->store('posts', 'public');
        }

        $post->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'activity_date' => $validated['activity_date'],
            'authors' => $validated['authors'],
            'content' => $validated['content'],
            'status' => $validated['status'],
            'main_image' => $post->main_image,
        ]);

        if ($request->hasFile('evidence_images')) {
            foreach ($request->file('evidence_images') as $index => $file) {
                $path = $file->store('evidences', 'public');
                PostImage::create([
                    'post_id' => $post->id,
                    'image_path' => $path,
                    'participant_name' => $request->input("evidence_participants.$index") ?: 'Ambos integrantes',
                    'caption' => $request->input("evidence_captions.$index"),
                ]);
            }
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Entrada actualizada correctamente.');
    }

    public function destroy(Post $post)
    {
        if ($post->main_image) {
            Storage::disk('public')->delete($post->main_image);
        }

        foreach ($post->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Entrada eliminada correctamente.');
    }

    public function destroyImage(PostImage $postImage)
    {
        Storage::disk('public')->delete($postImage->image_path);
        $postImage->delete();

        return back()->with('success', 'Evidencia fotográfica eliminada.');
    }
}