<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Avatar extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'profile_id'
    ];

    public function getImageAttribute($value)
    {
        return Storage::url($value);
    }

    public function setImageAttribute($value)
    {
        if ($value instanceof \Illuminate\Http\UploadedFile) {
            $filename = $value->getClientOriginalName();
            $path = $value->storeAs('uploads/avatar', $filename, 'public');
            $this->attributes['image'] = $path;
        } else {
            $this->attributes['image'] = $value;
        }
    }

    public static function store($request, $id=null){
        $data = $request->only('image');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = $file->storeAs('uploads/avatar', $filename, 'public');
            $data['image'] = Storage::url($path);
        }
        $media = self::updateOrCreate(['id' => $id], $data);

        return $media;
    }

    public static function destoy($id){
        $avatar = self::find($id);
        $avatar->delete();
    }
}
