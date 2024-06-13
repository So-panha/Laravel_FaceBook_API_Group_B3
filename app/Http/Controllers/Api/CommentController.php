<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $comments = Comment::all();
        return response()->json([
            "success" => true,
            "message" => "Comments retrieved successfully",
            "data" => CommentResource::collection($comments)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'text' => 'required|string',
            'user_id' => 'required|integer',
            'show_post_id' => 'required|integer',
        ]);

        $comment = Comment::create($validatedData);

        return response()->json([
            "success" => true,
            "message" => "Comment created successfully",
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $comment = Comment::findOrFail($id);
        return response()->json([
            "success" => true,
            "data" => new CommentResource($comment)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validatedData = $request->validate([
            'text' => 'required|string',
            'user_id' => 'required|integer',
            'show_post_id' => 'required|integer'
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update($validatedData);

        return response()->json([
            "success" => true,
            "message" => "Comment updated successfully"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json([
            "success" => true,
            "message" => "Comment deleted successfully"
        ], 200);
    }
}
