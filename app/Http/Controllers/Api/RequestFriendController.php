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

    /**
 * @OA\Post(
 *     path="/api/friend-requests/send",
 *     operationId="sendFriendRequest",
 *     tags={"Friend Requests"},
 *     summary="Send a friend request",
 *     description="Sends a new friend request",
 *     security={{"bearer_token":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="receiver_id", type="integer", example=2)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Friend request sent successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
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
