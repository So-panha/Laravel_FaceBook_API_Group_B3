<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'friend_id',
    ];

    public static function store($request){
        $data = $request->only('user_id', 'friend_id');
        $data = self::create($data);
        return $data;
    }
}
