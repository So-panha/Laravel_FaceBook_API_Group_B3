<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostUpdateResource;
use App\Models\Post;
use Auth;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts = Post::list();
        return response()->json([
            "success" => true,
            "message" => "Posts retrieved successfully",
            "data" => PostResource::collection($posts)
        ], 200);
    }

   /**
 * @OA\Post(
 *     path="/api/post/create",
 *     summary="Create a new post",
 *     description="Endpoint to create a new post.",
 *     operationId="createPost",
 *     tags={"Post"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="caption",
 *                 type="string",
 *                 example="New post caption",
 *                 description="Caption of the post"
 *             ),
 *             @OA\Property(
 *                 property="image",
 *                 type="array",
 *                 @OA\Items(
 *                     type="string",
 *                     example="http://example.com/image.jpg",
 *                     description="URL of an image associated with the post"
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="video",
 *                 type="array",
 *                 @OA\Items(
 *                     type="string",
 *                     example="http://example.com/video.mp4",
 *                     description="URL of a video associated with the post"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Post created successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="id",
 *                 type="integer",
 *                 example=1,
 *                 description="ID of the created post"
 *             ),
 *             @OA\Property(
 *                 property="caption",
 *                 type="string",
 *                 example="New post caption",
 *                 description="Caption of the post"
 *             ),
 *             @OA\Property(
 *                 property="user_id",
 *                 type="integer",
 *                 example=1,
 *                 description="ID of the user who created the post"
 *             ),
 *             @OA\Property(
 *                 property="created_at",
 *                 type="string",
 *                 format="date-time",
 *                 example="2023-01-01T00:00:00.000Z",
 *                 description="Timestamp when the post was created"
 *             ),
 *             @OA\Property(
 *                 property="updated_at",
 *                 type="string",
 *                 format="date-time",
 *                 example="2023-01-01T00:00:00.000Z",
 *                 description="Timestamp when the post was updated"
 *             ),
 *             @OA\Property(
 *                 property="images",
 *                 type="array",
 *                 description="Images associated with the post",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="image_url",
 *                         type="string",
 *                         example="http://example.com/image.jpg",
 *                         description="URL of the image"
 *                     )
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="videos",
 *                 type="array",
 *                 description="Videos associated with the post",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="video_url",
 *                         type="string",
 *                         example="http://example.com/video.mp4",
 *                         description="URL of the video"
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Invalid input data")
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
    public function store(PostRequest $request)
    {
        $post = new Post();
        $post->caption = $request->caption;
        $post->user_id = Auth()->user()->id;
        $post->image = $request->file('image');
        $post->video = $request->file('video');

        Post::store($post);

        return response()->json([
            "success" => true,
            "message" => "Post created successfully",
        ], 200);
    }

    /**
     * Display the specified resource.
     */

    /**
 * @OA\Get(
 *     path="/api/post/show/{id}",
 *     summary="Get a single post by ID",
 *     description="Endpoint to retrieve a single post by its ID.",
 *     operationId="getPostById",
 *     tags={"Post"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the post to retrieve",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Post retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="id",
 *                 type="integer",
 *                 example=1,
 *                 description="ID of the post"
 *             ),
 *             @OA\Property(
 *                 property="caption",
 *                 type="string",
 *                 example="This is a post caption",
 *                 description="Caption of the post"
 *             ),
 *             @OA\Property(
 *                 property="user_id",
 *                 type="integer",
 *                 example=1,
 *                 description="ID of the user who created the post"
 *             ),
 *             @OA\Property(
 *                 property="created_at",
 *                 type="string",
 *                 format="date-time",
 *                 example="2023-01-01T00:00:00.000Z",
 *                 description="Timestamp when the post was created"
 *             ),
 *             @OA\Property(
 *                 property="updated_at",
 *                 type="string",
 *                 format="date-time",
 *                 example="2023-01-01T00:00:00.000Z",
 *                 description="Timestamp when the post was updated"
 *             ),
 *             @OA\Property(
 *                 property="images",
 *                 type="array",
 *                 description="Images associated with the post",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="image_url",
 *                         type="string",
 *                         example="http://example.com/image.jpg",
 *                         description="URL of the image"
 *                     )
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="videos",
 *                 type="array",
 *                 description="Videos associated with the post",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="video_url",
 *                         type="string",
 *                         example="http://example.com/video.mp4",
 *                         description="URL of the video"
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Post not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Post not found")
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
    public function show(string $id)
    {
        //
        $post = Post::findOrFail($id);
        return response()->json([
            "success" => true,
            "data" => new PostResource($post)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */


    /**
 * @OA\Put(
 *     path="/api/post/{id}",
 *     summary="Update a post by ID",
 *     description="Endpoint to update a post by its ID.",
 *     operationId="updatePostById",
 *     tags={"Post"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the post to update",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="caption",
 *                 type="string",
 *                 example="Updated post caption",
 *                 description="New caption for the post"
 *             ),
 *             @OA\Property(
 *                 property="image",
 *                 type="array",
 *                 @OA\Items(
 *                     type="string",
 *                     example="http://example.com/new-image.jpg",
 *                     description="URL of an image to add/update"
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="video",
 *                 type="array",
 *                 @OA\Items(
 *                     type="string",
 *                     example="http://example.com/new-video.mp4",
 *                     description="URL of a video to add/update"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Post updated successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="id",
 *                 type="integer",
 *                 example=1,
 *                 description="ID of the updated post"
 *             ),
 *             @OA\Property(
 *                 property="caption",
 *                 type="string",
 *                 example="Updated post caption",
 *                 description="Updated caption of the post"
 *             ),
 *             @OA\Property(
 *                 property="user_id",
 *                 type="integer",
 *                 example=1,
 *                 description="ID of the user who updated the post"
 *             ),
 *             @OA\Property(
 *                 property="created_at",
 *                 type="string",
 *                 format="date-time",
 *                 example="2023-01-01T00:00:00.000Z",
 *                 description="Timestamp when the post was created"
 *             ),
 *             @OA\Property(
 *                 property="updated_at",
 *                 type="string",
 *                 format="date-time",
 *                 example="2023-01-02T00:00:00.000Z",
 *                 description="Timestamp when the post was updated"
 *             ),
 *             @OA\Property(
 *                 property="images",
 *                 type="array",
 *                 description="Updated images associated with the post",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="image_url",
 *                         type="string",
 *                         example="http://example.com/new-image.jpg",
 *                         description="URL of the updated image"
 *                     )
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="videos",
 *                 type="array",
 *                 description="Updated videos associated with the post",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="video_url",
 *                         type="string",
 *                         example="http://example.com/new-video.mp4",
 *                         description="URL of the updated video"
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Post not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Post not found")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Invalid input data")
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

        $post = Post::findOrFail($id);
        try{
            if($post->user_id == Auth()->user()->id){

                $updateData = new Post;
                $updateData->caption = $request->caption;
                $updateData->user_id = Auth()->user()->id;

                Post::updatePost($updateData,$id);
                return response()->json([
                    "success" => true,
                    "message" => "Post updated successfully",
                ], 200);
            }else{
                return response()->json([
                    "success" => false,
                    "message" => "You are not allowed to update this post"
                ], 400);
            }
        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 400);
        }

    }


    /**
     * Remove the specified resource from storage.
     */

    /**
 * @OA\Delete(
 *     path="/api/post/{id}",
 *     summary="Delete a post by ID",
 *     description="Endpoint to delete a post by its ID.",
 *     operationId="deletePostById",
 *     tags={"Post"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the post to delete",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Post deleted successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Post not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Post not found")
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
        $post = Post::findOrFail($id);
        try{
            if($post->user_id == Auth()->user()->id){

                $post->delete();
                return response()->json([
                    "success" => true,
                    "message" => "Post delete successfully",
                ], 200);
            }else{
                return response()->json([
                    "success" => false,
                    "message" => "You are not allowed to delete this post"
                ], 400);
            }
        }catch(Exception $e){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 400);
        }

    }
}
