<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $fillable = [
        'emoji_id',
        'show_post_id',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function emoji(){
        return $this->hasOne(Emoji::class);
    }

    public static function store($request, $id = null){
        $data = $request->only( 'user_id','show_post_id','emoji_id');
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
        
    }

    public static function destoy($id){
        $emoji = self::find($id);
        $emoji->delete();
    }


    
    
}
