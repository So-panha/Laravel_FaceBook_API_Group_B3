<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaVideo extends Model
{
    use HasFactory;
    protected $fillable = [
        'video_url',
        'post_id',
    ];

    public function getVideoUrlAttribute($value)
    {
        return Storage::url($value);
    }

    public function setVideoUrlAttribute($value)
    {
        if ($value instanceof \Illuminate\Http\UploadedFile) {
            $filename = $value->getClientOriginalName();
            $path = $value->storeAs('uploads/MediaVideo', $filename, 'public');
            $this->attributes['video_url'] = $path;
        } else {
            $this->attributes['video_url'] = $value;
        }
    }
}
