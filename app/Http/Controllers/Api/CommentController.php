<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
 * @OA\Get(
 *     path="/api/comment/list",
 *     operationId="createComment",
 *     tags={"Comments"},
 *     summary="Store a new comment",
 *     description="Stores a new comment",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="text", type="string", example="This is a comment."),
 *             @OA\Property(property="post_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Comment created successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */
    public function index()
    {
        //
        $comments = Comment::list();
        return response()->json([
            "success" => true,
            "message" => "Comments retrieved successfully",
            "data" => CommentResource::collection($comments)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * @OA\Post(
     *     path="/api/comment/create",
     *     operationId="storeComment",
     *     tags={"Comments"},
     *     summary="Store a new comment",
     *     description="Stores a new comment",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="text", type="string", example="This is a comment."),
     *             @OA\Property(property="post_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Comment created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function store(CommentRequest $request)
    {
        $comment = new Comment;
        $comment->text = $request->text;
        $comment->user_id = Auth()->user()->id;
        $comment->post_id = $request->post_id;

        Comment::store($comment);
        return response()->json([
            "success" => true,
            "message" => "Comment created successfully",
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    /**
 * @OA\Get(
 *     path="/api/comment/show/{id}",
 *     operationId="showComment",
 *     tags={"Comments"},
 *     summary="Show a comment",
 *     description="Retrieves a comment",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="text", type="string", example="This is a comment."),
 *             @OA\Property(property="post_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Comment retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     )
 * )
 */
    public function show(string $id)
    {
        //
        $comment = Comment::findOrFail($id);
        return response()->json([
            "success" => true,
            "data" => new CommentResource($comment)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
 * @OA\Put(
 *     path="/api/comment/update/{id}",
 *     operationId="updateComment",
 *     tags={"Comments"},
 *     summary="Update a comment",
 *     description="Updates an existing comment",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="text", type="string", example="This is an updated comment.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Comment updated successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */
    public function update(Request $request, string $id)
    {
        //
        $validatedData = $request->validate([
            'text' => 'required|string',
            'user_id' => 'required|integer',
            'show_post_id' => 'required|integer'
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update($validatedData);

        return response()->json([
            "success" => true,
            "message" => "Comment updated successfully"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
 * @OA\Delete(
 *     path="/api/comment/delete/{id}",
 *     operationId="deleteComment",
 *     tags={"Comments"},
 *     summary="Delete a comment",
 *     description="Deletes an existing comment",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Comment deleted successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */
    public function destroy(string $id)
    {
        //
        $comment = Comment::findOrFail($id);
        try {
            if ($comment->user_id == Auth()->user()->id) {

                $comment->delete();
                return response()->json([
                    "success" => true,
                    "message" => "Remove comment successfully",
                ], 200);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "You are not allowed to comment with this"
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
