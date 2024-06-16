<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'birthday',
        'place',
        'bio',
    ];
    public function avatar(){
        return $this->hasMany(Avatar::class,'profile_id');
    }

    public static function store($request, $id = null){
        // dd($request);
        $data = $request->only('user_id','birthday','place','bio');
        $data = self::updateOrCreate(['id' => $id], $data);
        $data->avatar()->create(['image' => $request->avatar]);
        return $data;

    }

    public static function show($request, $id = null){
        $profile = self::find($id);
        return $profile;
    }



}
