<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts = Post::list();
        return response()->json([
            "success" => true,
            "message" => "Posts retrieved successfully",
            "data" => PostResource::collection($posts)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {

        $post = new Post();
        $post->caption = $request->caption;
        $post->user_id = Auth()->user()->id;
        $post->image = $request->file('image');
        $post->video = $request->file('video');

        Post::store($post);

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
        dd($request);
        $validatedData = $request->validate([
            'caption' => 'required|string',
            'photo_id' => 'required|string',
            'video_id' => 'required|string',
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
