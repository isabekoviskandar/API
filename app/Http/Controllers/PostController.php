<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::select('posts.id', 'posts.title', 'posts.description', 'posts.image', 'categories.name as category_name')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->get();
    
        return response()->json($posts);
    }
    
    

    public function show($id)
    {
        $post = Post::with('category')->find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json($post);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|string',
        ]);

        $post = Post::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
        ]);

        return response()->json(['message' => 'Post created successfully', 'data' => $post], 201);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string', 
        ]);

        $post->update([
            'category_id' => $request->category_id ?? $post->category_id,
            'title' => $request->title ?? $post->title,
            'description' => $request->description ?? $post->description,
            'image' => $request->image ?? $post->image,
        ]);

        return response()->json(['message' => 'Post updated successfully', 'data' => $post]);
    }

    public function delete($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
