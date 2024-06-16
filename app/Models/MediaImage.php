<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'image_url',
        'post_id',
    ];

    public function getImageUrlAttribute($value)
    {
        return Storage::url($value);
    }

    public function setImageUrlAttribute($value)
    {
        if ($value instanceof \Illuminate\Http\UploadedFile) {
            $filename = $value->getClientOriginalName();
            $path = $value->storeAs('uploads/MediaImage', $filename, 'public');
            $this->attributes['image_url'] = $path;
        } else {
            $this->attributes['image_url'] = $value;
        }
    }

}
