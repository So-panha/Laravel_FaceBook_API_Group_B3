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
        // dd(Auth()->user()->id);
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
    }
}
