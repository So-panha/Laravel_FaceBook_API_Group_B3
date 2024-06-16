<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    /**
     * @OA\Get(
     *     path="/api/like/list",
     *     summary="List likes",
     *     description="Endpoint to retrieve a list of likes.",
     *     operationId="listLikes",
     *     tags={"Like"},
     *     @OA\Response(
     *         response=200,
     *         description="List of likes retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1,
     *                     description="ID of the like"
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     example=101,
     *                     description="ID of the user who liked"
     *                 ),
     *                 @OA\Property(
     *                     property="emoji_id",
     *                     type="integer",
     *                     example=201,
     *                     description="ID of the emoji liked"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     example="2024-06-17 12:34:56",
     *                     description="Date and time when the like was created"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Internal server error")
     *         )
     *     )
     * )
     */

    public function index()
    {
        //
        $likes = Like::all();
        return response(['success' => true, 'data' => $likes], 200);

    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * @OA\Post(
     *     path="/api/like/create",
     *     summary="Create a like",
     *     description="Endpoint to create a like on an item.",
     *     operationId="createLike",
     *     tags={"Like"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"user_id", "emoji_id"},
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     example=101,
     *                     description="ID of the user who is liking the item"
     *                 ),
     *                 @OA\Property(
     *                     property="emoji_id",
     *                     type="integer",
     *                     example=201,
     *                     description="ID of the emoji to be liked"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Like created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Like created successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Invalid input"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Internal server error"
     *             )
     *         )
     *     )
     * )
     */

    public function store(Request $request)
    {
        //
        $like = new Like();
        $like->user_id = Auth()->user()->id;
        $like->post_id = $request->post_id;
        $like->emoji_id = $request->emoji_id;

        // dd($like);

        Like::store($like);

        return ["success" => true, "Message" => "Like created successfully"];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */


    /**
     * @OA\Delete(
     *     path="/api/like/delete/{id}",
     *     summary="Delete a like",
     *     description="Endpoint to delete a like by its ID.",
     *     operationId="deleteLike",
     *     tags={"Like"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             description="ID of the like to delete"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Like deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Like deleted successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Like not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Like not found"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Internal server error"
     *             )
     *         )
     *     )
     * )
     */

    public static function destroy($id)
    {

        $like = Like::findOrFail($id);
        try {
            if ($like->user_id == Auth()->user()->id) {

                $like->delete();
                return response()->json([
                    "success" => true,
                    "message" => "Unlike successfully",
                ], 200);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "You are not allowed to dislike with this"
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 400);
        }
    }

}
