<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
        'emoji_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function emoji(): BelongsTo
    {
        return $this->belongsTo(Emoji::class);
    }

    public static function store($request, $id = null){
        $data = $request->only('user_id','post_id','emoji_id');
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
    }


}
