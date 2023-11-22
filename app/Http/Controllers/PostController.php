<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function createBlog(Request $request): JsonResponse
    {
        $post = Post::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'user_id' => $request->input('user_id'),
        ]);
        
        return response()->json($post, 201);
    }

    public function getBlogById(int $id): JsonResponse
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }

    public function updateBlog(Request $request, int $id): JsonResponse
    {
        $post = Post::findOrFail($id);
        $post->update([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);
        return response()->json($post);
    }

    public function deleteBlog(int $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->noContent();
    }
}
