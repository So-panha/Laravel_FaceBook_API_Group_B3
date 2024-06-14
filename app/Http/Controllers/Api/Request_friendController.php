<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Request_friendResource;
use App\Models\Request_friend;
use Illuminate\Http\Request;

class Request_friendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $request_friends = Request_friend::all();
        return response()->json([
            "success" => true,
            "message" => "Request_friends retrieved successfully",
            "data" => Request_friendResource::collection($request_friends)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'sender_id' => 'required|integer',
            'reciever_id' => 'required|integer',
        ]);

        $request_friend = Request_friend::create($validatedData);

        return response()->json([
            "success" => true,
            "message" => "Request_friend created successfully",
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $request_friend = Request_friend::findOrFail($id);
        return response()->json([
            "success" => true,
            "data" => new Request_friendResource($request_friend)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validatedData = $request->validate([
            'sender_id' => 'required|integer',
            'reciever_id' => 'required|integer',
        ]);

        $request_friend = Request_friend::findOrFail($id);
        $request_friend->update($validatedData);

        return response()->json([
            "success" => true,
            "message" => "Request_friend updated successfully"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $request_friend = Request_friend::findOrFail($id);
        $request_friend->delete();

        return response()->json([
            "success" => true,
            "message" => "Request_friend deleted successfully"
        ], 200);
    }
}
