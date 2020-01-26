<?php

namespace App\Handlers;

use Illuminate\Support\Str;
// use Image;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageUploadHandler
{
    protected $allowed_ext = ['png', 'jpg', 'gif', 'jpeg'];

    public function save($file, $folder, $file_prefix, $max_width=false)
    {
        $folder_name = "uploads/images/$folder/" . date("Ym/d", time());

        $upload_path = public_path() . '/' . $folder_name;

        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        $file_name = $file_prefix . '_' . time() . Str::random(10) . '.' . $extension;

        if (! in_array($extension, $this->allowed_ext)) {
            return false;
        }

        $file->move($upload_path, $file_name);

        if ($max_width && $extension != 'gif') {
            $this->reduceSize("$upload_path/$file_name", $max_width);
       }

        if (env('UPLOAD_DISK') == 's3'){
            Storage::disk('s3')->putFileAs($folder_name, "$upload_path/$file_name", $file_name);
            $file_path = Storage::disk('s3')->url("$folder_name/$file_name");
        } else {
            $file_path = config('app.url') . "/$folder_name/$file_name";
        }

        return [
            'path' => $file_path,
        ];
    }


    public function reduceSize($file_path, $max_width)
    {
        $image = Image::make($file_path);

        $image->resize($max_width, null, function($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $image->save();

    }
}
