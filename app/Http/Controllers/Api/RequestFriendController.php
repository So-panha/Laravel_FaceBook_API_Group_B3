<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestFriendRequest;
use App\Http\Resources\ListFriendRequestResource;
use App\Http\Resources\ShowUserResource;
use App\Models\RequestFriend;
use Illuminate\Http\Request;

class RequestFriendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function sendRequest(RequestFriendRequest $request)
    {
        //
        $addFriend = new RequestFriend;
        $addFriend->sender_id = Auth()->user()->id;
        $addFriend->receiver_id = $request->receiver_id;

        RequestFriend::store($addFriend);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function listFriendsRequest()
    {
        //
        $listFriendsRequest = RequestFriend::where('receiver_id', Auth()->user()->id)->get();
        $listFriendsRequest = ListFriendRequestResource::collection($listFriendsRequest);
        return $listFriendsRequest;
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
