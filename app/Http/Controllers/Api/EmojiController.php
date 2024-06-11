<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Emoji;
use Illuminate\Http\Request;

class EmojiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $emojis= Emoji::all();
        return response(['success' => true, 'data' =>$emojis], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        
        Emoji::store($request);
        return ["success" => true, "Message" =>"reaction created successfully"];
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
        Emoji::find($id)->update($request->only('emoji'));
        return ["success" => true, "Message" =>"reaction updated successfully"];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd(1);
        Emoji::find($id)->delete();
        return ["success" => true, "Message" =>"Reaction deleted successfully"];
    }
    
}
