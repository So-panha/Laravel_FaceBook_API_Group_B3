<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'text',
        'user_id',
        'post_id',
    ];

    public static function list()
    {
        return self::all();
    }

    public static function store($request, $id = null){
        $data = $request->only('text','user_id','post_id');
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
