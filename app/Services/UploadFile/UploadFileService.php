<?php

namespace App\Services\UploadFile;

use Illuminate\Support\Facades\Storage;

class UploadFileService implements  UploadFileServiceInterface
{
    public function uploadFile($file, $path): array
    {
        try {
            $fileExtension = $this->getFileExtension($file);
            $fileName = $this->getFileName($file);
            $rdFileName = trim($fileName, $fileExtension) . '_' . time() . '_' . rand(1000, 9999) . '.' . $fileExtension;
            $urlImage = $path . $rdFileName;
            Storage::disk('local')->putFileAs($path, $file, $rdFileName);

            return [
                "success" => true,
                "urlImage" => $urlImage
            ];
        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    public function getFileUrl($path, $defaultImage = null): string
    {
        $disk = Storage::disk('local');
        $image = null;
        if ($disk->exists($path)) {
            $image = $disk->get('path');
        }
        $image = $defaultImage;

        return $image;
    }

    public function deleteFile($path):void
    {
        $disk = Storage::disk('local');
        if ($disk->exists($path)) {
            $disk->delete($path);
        }
    }

    private function getFileName($file)
    {
        return $file->getClientOriginalName();
    }

    private function getFileExtension($file)
    {
        return $file->getClientOriginalExtension();
    }

    private function getFileRealPath($file)
    {
        return $file->getRealPath();
    }

    private function getFileSize($file)
    {
        return $file->getSize();
    }

    private function getFileType($file)
    {
        return $file->getMimeType();
    }
}
