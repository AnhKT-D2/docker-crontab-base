<?php

namespace App\Services\UploadFileS3;

interface UploadFileServiceInterface
{
    public function uploadFileToS3($file, $path);

    public function getS3FileUrl($path, $defaultImage = null);

    public function deleteFileFromS3($path);
}
