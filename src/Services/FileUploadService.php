<?php

namespace Vellum\Services;

use Vellum\Uploader\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;


class FileUploadService 
{
    public static function make($request)
    {
        foreach($request as $key => $field) {
            if($field instanceof UploadedFile){
                $image = self::upload($field, 'uploads', 'ugc');
                $newKey = str_replace('-uploader', '', $key);
                $request[$newKey] = $image;
                unset($request[$key]);
            }
        }

        return $request;
    }

    public static function upload(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);

        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }
}