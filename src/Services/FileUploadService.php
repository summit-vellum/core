<?php

namespace Vellum\Services;

use Vellum\Uploader\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Vellum\Helpers\AwsHelper as AWS;

class FileUploadService
{
    public static function make($request)
    {
        foreach ($request as $key => $field) {
            if ($field instanceof UploadedFile) {

                $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
        		$image_name = seoUrl($name, '-').'-'.time().'.'.strtolower($extension);

        		$image = self::upload($field, 'uploads', 'ugc', $image_name);

                $newKey = str_replace('-uploader', '', $key);
                $request[$newKey] = $image;
                unset($request[$key]);
            }
        }

        return $request;
    }

    public static function upload(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);

        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }
}
