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
    ];
    public function avatar(){
        return $this->hasMany(Avatar::class,'profile_id');
    }
    
    public static function store($request, $id = null){
        $data = $request->only( 'birthday','place','bio');
        $data = self::updateOrCreate(['id' => $id], $data);
        $data->avatar()->create(['image' => $request->file('avatar')]);
        return $data;
        
    }

    public static function show($request, $id = null){
        $profile = self::find($id);
        return $profile;
    }



}
