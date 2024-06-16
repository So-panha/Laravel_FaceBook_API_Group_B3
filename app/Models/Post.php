<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'caption',
        'user_id',
    ];
    // User relationship
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // Image relationship
    public function image():HasMany
    {
        return $this->hasMany(MediaImage::class,'post_id');
    }
    // Video relationship
    public function video()
    {
        return $this->hasMany(MediaVideo::class);
    }

    public static function list()
    {
        return self::all();
    }

    public static function store($request)
    {
        $data = $request->only('caption','user_id');
        $data = self::create($data);

        // fecth into table image
        if ($request->image != null) {
            $arr = [$request->image];
            if ($arr > 1) {
                foreach ($request->image as $image) {
                    $data->image()->create(['image_url' => $image]);
                }
            }
        }
        // fecth into table video
        if($request->video != null){
            $arr = [$request->video];
            if (count($arr) > 1) {
                foreach ($request->video as $video) {
                    $data->video()->create(['video_url' => $video]);
                }
            }
        }
        return $data;
    }


    public static function updatePost($request, $id){
        $data = $request->only('caption','user_id');
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
    }

}

