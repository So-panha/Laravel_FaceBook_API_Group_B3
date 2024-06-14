<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Share;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $shares= Share::all();
        return response(['success' => true, 'data' =>$shares], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Share::store($request);
        return ["success" => true, "Message" =>"Share created successfully"];

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
        Share::store($request);
        return ["success" => true, "Message" =>"Share updated successfully"];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Share::find($id)->delete();
        return ["success" => true, "Message" =>"Share deleted successfully"];
    }
}
