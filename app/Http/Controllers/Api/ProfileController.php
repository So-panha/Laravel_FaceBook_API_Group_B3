<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShowProfileResource;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
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
 *     path="/api/profile/create",
 *     summary="Create a profile",
 *     description="Endpoint to create a new user profile.",
 *     operationId="createProfile",
 *     tags={"Profile"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"birthday", "place", "bio"},
 *                 @OA\Property(
 *                     property="id",
 *                     type="integer",
 *                     example=1,
 *                     description="ID of the profile"
 *                 ),
 *                 @OA\Property(
 *                     property="birthday",
 *                     type="string",
 *                     format="date",
 *                     example="2006-06-06",
 *                     description="Birth date for the user"
 *                 ),
 *                 @OA\Property(
 *                     property="place",
 *                     type="string",
 *                     example="Pursat province",
 *                     description="Place address of user"
 *                 ),
 *                 @OA\Property(
 *                     property="bio",
 *                     type="string",
 *                     example="Passionate about coding and technology",
 *                     description="Biography or description of the user"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Profile created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Profile created successfully"
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
        try{
            $profile = new Profile;
            $profile->user_id = Auth()->user()->id;
            $profile->birthday = $request->birthday;
            $profile->place = $request->place;
            $profile->bio = $request->bio;
            $profile->avatar = $request->file('avatar');
            $profile = Profile::store($profile);
            return ["success" => true, "Message" => "Profile created successfully"];
        }catch(\Throwable){
            return response()->json([
                "success" => false,
                "message" => "Your already have profile"
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
        $profile = Profile::where('user_id', Auth()->user()->id)->first();
        $profile = new ShowProfileResource ($profile);
        return ["success" => true, "data" =>$profile];
    }

    /**
     * Update the specified resource in storage.
     */


    /**
 * @OA\Put(
 *     path="/api/profile/update/{id}",
 *     summary="Update a profile",
 *     description="Endpoint to update an existing user profile.",
 *     operationId="updateProfile",
 *     tags={"Profile"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the profile to update",
 *         @OA\Schema(
 *             type="integer",
 *             example=1
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="birthday",
 *                     type="string",
 *                     format="date",
 *                     example="2006-06-06",
 *                     description="New birth date for the user"
 *                 ),
 *                 @OA\Property(
 *                     property="place",
 *                     type="string",
 *                     example="Pursat province",
 *                     description="New place address of user"
 *                 ),
 *                 @OA\Property(
 *                     property="bio",
 *                     type="string",
 *                     example="Updated biography about coding and technology",
 *                     description="New biography or description of the user"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Profile updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Profile updated successfully"
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
 *         response=404,
 *         description="Profile not found",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Profile not found"
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

    public function update(Request $request, string $id)
    {
        $profile = Profile::store($request, $id);
        return ["success" => true, "Message" =>"Profile updated successfully"];
    }

}
