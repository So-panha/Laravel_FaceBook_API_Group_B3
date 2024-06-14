<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'birthday',
        'place',
        'bio',
        'avatar_id',
        
    ];
    public static function store($request, $id = null){
        $data = $request->only( 'birthday','place','bio','avatar_id' );
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
        
    }
    public static function show($request, $id = null){
        $profile = self::find($id);
        return $profile;
    }



}
