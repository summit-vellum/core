<?php

namespace Vellum\Services;

use Vellum\Uploader\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Vellum\Helpers\AwsHelper as AWS;
use Illuminate\Support\Facades\Route;

class FileUploadService
{
    public static function make($request)
    {
        foreach ($request as $key => $field) {
            if ($field instanceof UploadedFile) {

        		$image = self::upload($field, 'uploads', 'ugc');

                $newKey = str_replace('-uploader', '', $key);
                $request[$newKey] = $image;
                unset($request[$key]);
            }
        }

        return $request;
    }

    public static function upload(UploadedFile $uploadedFile, $folder = null, $disk = 'public')
    {
    	$module = explode('.', Route::current()->getName())[0];

    	$site = config('site');
    	$date = date('Y/m/d');
    	$name = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $uploadedFile->getClientOriginalExtension();
		$filename = seoUrl($name, '-').'-'.time().'.'.strtolower($extension);
		$imagePath = $site['image_path'].$date.'/'. $filename;

    	if (in_array($module, config('aws_site'))) {
    		$aws = new AWS;
    		$aws->uploadFileToS3($imagePath, $uploadedFile->getPathName(), $extension);
    	}

        $name = !is_null($filename) ? $filename : Str::random(25);

        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }
}
