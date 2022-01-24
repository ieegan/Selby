<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    static public function uploadImage($file, $hash, $size = 256)
    {
        $path = $file->hashName($hash);

        $image = Image::make($file);

        if ($size != null) {
            $image->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        Storage::put($path, (string) $image->encode());

        $thumbnail = Image::make($file);
        $thumbnail->resize(256, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        Storage::put('thumbnails/' . $path, (string) $thumbnail->encode());

        return $path;
    }

    public function upload(Request $request)
    {
        $path = ImageController::uploadImage($request->file('files')[0], 'images/upload', null);

        return [
            'files' => [
                [
                    "url" => Storage::URL($path)
                ]
            ]
        ];
    }
}
