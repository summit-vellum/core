<?php

namespace Vellum\Helpers;

use AWS;
use Aws\Common\Credentials\Credentials;
use Aws\S3\S3Client;
use Aws\Sqs\SqsClient;


class AwsHelper
{

	public $aws_bucket;

	public $aws_bucket_images;

	public $aws_bucket_url;

	public $site;

    public function __construct()
    {
    	$this->aws_bucket = env('AWS_BUCKET');
    	$this->aws_bucket_images = env('AWS_BUCKET_IMAGES');
    	$this->aws_bucket_url = env('AWS_IMAGE_URL');
    	$this->site = config('site');
    }

    /**
     * Uploads json data to s3.
     *
     * @param      string  $key    file path and file name
     * @param      json  $body   json data
     */
    public function uploadToS3($key, $body, $attr)
    {
        $s3 = AWS::get('s3');
        $test = $s3->putObject(array(
            'Bucket' => $this->aws_bucket,
            'Key'    => $key,
            'Body'   => $body,
            'ACL'    => 'public-read',
        ));
    }


    /**
     * Uploads a file to s3.
     *
     * @param      string  $key         File path and file name
     * @param      string  $sourceFile  local path
     * @param      string  $ext         The extention
     */
    public function uploadFileToS3($key, $sourceFile, $ext, $site)
    {
        $key = $siteImgFolder.'/'.$key;

        $s3 = AWS::get('s3');
        $result = $s3->putObject(array(
            'Bucket'       => $this->aws_bucket_images,
            'Key'          => $key,
            'SourceFile'   => $sourceFile,
            'Body'         => '',
            'ContentType'  => $ext,
            'ACL'          => 'public-read',
            'CacheControl' => 'max-age=31536000'
        ));
    }

}
