<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Show_PostResource;
use App\Models\Show_post;
use Illuminate\Http\Request;

class Show_postController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $show_posts = Show_post::all();
        return response()->json([
            "success" => true,
            "message" => "Show_Posts retrieved successfully",
            "data" => Show_PostResource::collection($show_posts)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'post_id' => 'required|integer'
        ]);

        $show_post = Show_post::create($validatedData);

        return response()->json([
            "success" => true,
            "message" => "Show_post created successfully",
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $show_post = Show_post::findOrFail($id);
        return response()->json([
            "success" => true,
            "data" => new Show_PostResource($show_post)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validatedData = $request->validate([
            'post_id' => 'required|integer',
        ]);

        $show_post = Show_post::findOrFail($id);
        $show_post->update($validatedData);

        return response()->json([
            "success" => true,
            "message" => "Show_post updated successfully",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $show_post = Show_post::findOrFail($id);
        $show_post->delete();

        return response()->json([
            "success" => true,
            "message" => "Show_post deleted successfully"
        ], 200);
    }
}
