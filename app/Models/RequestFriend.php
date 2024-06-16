<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestFriend extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_id',
        'receiver_id',
    ];

    public function sender(){
        return $this->belongsTo(User::class,'sender_id');
    }

    public static function store($request, $id = null){
        $data = $request->only('sender_id','receiver_id');
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
    }

}
