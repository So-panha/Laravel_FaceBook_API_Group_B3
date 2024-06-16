<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use Illuminate\Http\Request;




class AvatarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
 * @OA\Post(
 *     path="/api/avatar/create",
 *     summary="Create an avatar",
 *     description="Endpoint to create and upload an avatar image.",
 *     operationId="createAvatar",
 *     tags={"Avatar"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"image"},
 *                 @OA\Property(
 *                     property="image",
 *                     type="string",
 *                     format="binary",
 *                     description="Avatar image file"
 *                 ),
 *                 @OA\Property(
 *                     property="profile_id",
 *                     type="integer",
 *                     description="Profile ID associated with the avatar"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Avatar created successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="id",
 *                 type="integer",
 *             ),
 *             @OA\Property(
 *                 property="image",
 *                 type="string",
 *             ),
 *             @OA\Property(
 *                 property="profile_id",
 *                 type="integer",

 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string")
 *         )
 *     )
 * )
 */

    public function store(Request $request)
    {
        //
        $avatar = Avatar::store($request);
        return ["success" => true, "Message" =>"Avatar created successfully"];
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
 *     path="/api/avatar/delete/{id}",
 *     summary="Delete an avatar",
 *     description="Endpoint to delete an avatar image by its ID.",
 *     operationId="deleteAvatar",
 *     tags={"Avatar"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             description="ID of the avatar to be deleted"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Avatar deleted successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Avatar deleted successfully"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Invalid ID supplied")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not Found",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Avatar not found")
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

    public function destroy(string $id)
    {
        //
        Avatar::find($id)->delete();
        return ["success" => true, "Message" =>"Avatar deleted successfully"];
    }
}
