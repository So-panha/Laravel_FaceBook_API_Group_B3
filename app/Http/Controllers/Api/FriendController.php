<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FriendResource;
use App\Models\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $friends = Friend::all();
        return response()->json([
            "success" => true,
            "message" => "Friends retrieved successfully",
            "data" => FriendResource::collection($friends)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'friend_id' => 'required|integer',
        ]);

        $friend = Friend::create($validatedData);

        return response()->json([
            "success" => true,
            "message" => "Friend created successfully",
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $friend = Friend::findOrFail($id);
        return response()->json([
            "success" => true,
            "data" => new FriendResource($friend)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'friend_id' => 'required|integer',
        ]);

        $friend = Friend::findOrFail($id);
        $friend->update($validatedData);

        return response()->json([
            "success" => true,
            "message" => "Friend updated successfully"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $friend = Friend::findOrFail($id);
        $friend->delete();

        return response()->json([
            "success" => true,
            "message" => "Friend deleted successfully"
        ], 200);
    }
}
