<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',

    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function post(){
        return $this->belongsTo(Post::class);
    }

    public static function store($request, $id = null){
        $data = $request->only( 'user_id','post_id');
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
        
    }

}
