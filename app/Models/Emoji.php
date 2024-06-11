<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Emoji extends Model
{
    use HasFactory;


  

    protected $fillable = ['name','emoji'];
    public static function store($request, $id=null){
        $data = $request->only('name','emoji');
        if ($request->hasFile('emoji')) {
            $file = $request->file('emoji');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = $file->storeAs('uploads/emoji', $filename, 'public');
            $data['emoji'] = Storage::url($path);
        }
        $media = self::updateOrCreate(['id' => $id], $data);

        return $media;
    }

    public static function destoy($id){
        $emoji = self::find($id);
        $emoji->delete();
    }
}


