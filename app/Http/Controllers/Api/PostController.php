<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts = Post::all();
    return response()->json([
        "success" => true,
        "message" => "Posts retrieved successfully",
        "data" => PostResource::collection($posts)
    ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'caption' => 'required|string',
            'user_id' => 'required|integer',
            'photo_id' => 'required|integer',
            'video_id' => 'required|integer',
        ]);

        $post = Post::create($validatedData);

        return response()->json([
            "success" => true,
            "message" => "Post created successfully",
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $post = Post::findOrFail($id);
        return response()->json([
            "success" => true,
            "data" => new PostResource($post)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validatedData = $request->validate([
            'caption' => 'required|string',
            'user_id' => 'required|integer',
            'photo_id' => 'required|integer',
            'video_id' => 'required|integer',
        ]);

        $post = Post::findOrFail($id);
        $post->update($validatedData);

        return response()->json([
            "success" => true,
            "message" => "Post updated successfully",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            "success" => true,
            "message" => "Post deleted successfully"
        ], 200);
    }
}
