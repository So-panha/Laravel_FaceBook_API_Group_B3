<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Emoji;
use Exception;
use Illuminate\Http\Request;


class EmojiController extends Controller
{

    /**
     * Display a listing of the resource.
     */


    /**
 * @OA\Get(
 *     path="/api/emoji/list",
 *     summary="List emojis",
 *     description="Endpoint to retrieve a list of emojis.",
 *     operationId="listEmojis",
 *     tags={"Emoji"},
 *     @OA\Response(
 *         response=200,
 *         description="List of emojis retrieved successfully",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(
 *                     property="id",
 *                     type="integer",
 *                 ),
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",

 *                 ),
 *                 @OA\Property(
 *                     property="url",
 *                     type="string",
 *                 )
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



    public function index()
    {
        //
        $emojis = Emoji::all();
        return response(['success' => true, 'data' => $emojis], 200);
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * @OA\Post(
     *     path="/api/emoji/create",
     *     summary="Create an emoji",
     *     description="Endpoint to create and upload an emoji image.",
     *     operationId="createEmoji",
     *     tags={"Emoji"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"image", "name"},
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     format="binary",
     *                     description="Emoji image file"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Name of the emoji"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Emoji created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="id",
     *                 type="integer",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="smiley"
     *             ),
     *             @OA\Property(
     *                 property="url",
     *                 type="string",
     *                 example="https://example.com/emojis/smiley.png"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid input")
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


    public function store(Request $request)
    {
        //

        Emoji::store($request);
        return ["success" => true, "Message" => "reaction created successfully"];
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


    /**
     * @OA\Put(
     *     path="/api/emoji/update/{id}",
     *     summary="Update an emoji",
     *     description="Endpoint to update an existing emoji.",
     *     operationId="updateEmoji",
     *     tags={"Emoji"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             description="ID of the emoji to be updated"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"name"},
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     format="binary",
     *                     description="New emoji image file (optional)"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="New name of the emoji"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Emoji updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="id",
     *                 type="integer",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="smiley"
     *             ),
     *             @OA\Property(
     *                 property="url",
     *                 type="string",
     *                 example="https://example.com/emojis/smiley.png"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid input")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Emoji not found")
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

    public function update(Request $request, string $id)
    {
        //
        try {
            Emoji::find($id)->update($request->only('name', 'emoji'));
            return ["success" => true, "Message" => "reaction updated successfully"];
        }catch (Exception $e) {
            return ["success" => false, "Message" => $e->getMessage()];
        }

    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *     path="/api/emoji/delete/{id}",
     *     summary="Delete an emoji",
     *     description="Endpoint to delete an existing emoji by ID.",
     *     operationId="deleteEmoji",
     *     tags={"Emoji"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             description="ID of the emoji to delete"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Emoji deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Emoji deleted successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Emoji not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Emoji not found"
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

    public function destroy(string $id)
    {
        // dd(1);
        try{
            $emoji = Emoji::find($id);
            $emoji->delete();
            return ["success" => true, "Message" => "Reaction deleted successfully"];
        }catch(\Throwable){
            return ["success" => false, "Message" => "Reaction not found"];
        }
    }

}
