<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class WebPostController extends Controller
{
    public function createBlog(Request $request): JsonResponse
    {
        $post = Post::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'user_id' => Auth::user()->id,
        ]);
        
        return response()->json($post, 201);
    }

    public function getBlogById(int $id): JsonResponse
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }
}
