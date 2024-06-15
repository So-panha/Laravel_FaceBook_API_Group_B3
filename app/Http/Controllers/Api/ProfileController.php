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
    public function store(Request $request)
    {
        //
        $profile = Profile::store($request);
        return ["success" => true, "Message" =>"Profile created successfully"];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $profile = Profile::find($id);
        $profile = new ShowProfileResource ($profile);
        return ["success" => true, "data" =>$profile];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $profile = Profile::store($request, $id);
        return ["success" => true, "Message" =>"Profile updated successfully"];
    }

    // public function edit($request, $id){
    //     $profile = Profile::store($request, $id);
    //     return ["success" => true, "Message" =>"Profile updated successfully"];
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
