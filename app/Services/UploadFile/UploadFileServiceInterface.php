<?php

namespace App\Services\UploadFile;

interface UploadFileServiceInterface
{
    public function uploadFile($file, $path);

    public function getFileUrl($path, $defaultImage = null);

    public function deleteFile($path);
}
