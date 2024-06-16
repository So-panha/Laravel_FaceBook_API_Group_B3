<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FriendListResource;
use App\Models\Friend;
use Illuminate\Http\Request;

class ListFriendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $listFriends = Friend::where('user_id',Auth()->user()->id)->get();
        $listFriends = FriendListResource::collection($listFriends);
        return response()->json(['success' => true, 'listFriends' => $listFriends]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $friend = Friend::findOrFail($id);
        try {
            if ($friend->user_id == Auth()->user()->id) {

                $friend->delete();
                return response()->json([
                    "success" => true,
                    "message" => "Remove friend successfully",
                ], 200);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "You are not allowed to friend with friend"
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 400);
        }
    }
}
