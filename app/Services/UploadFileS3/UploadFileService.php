<?php

namespace App\Services\UploadFileS3;

use Aws\S3\Exception\S3Exception;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadFileService implements UploadFileServiceInterface
{
    public function uploadFileToS3($file, $path): array
    {
        try {
            $fileExtension = $this->getFileExtension($file);
            $fileName = $this->getFileName($file);
            $rdFileName = trim($fileName, $fileExtension) . '_' . time() . '_' . rand(1000, 9999) . '.' . $fileExtension;
            $urlImage = $path . $rdFileName;
            Storage::disk('s3')->putFileAs($path, $file, $rdFileName);

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

    public function getS3FileUrl($path, $defaultImage = null): string
    {
        try {
            $disk = Storage::disk('s3');
            if ($disk->exists($path)) {
                $s3Client = $disk->getDriver()->getAdapter()->getClient();
                $command = $s3Client->getCommand(
                    'GetObject',
                    [
                        'Bucket' => config('filesystems.disks.s3.bucket'),
                        'Key' => $path,
                        'ResponseContentDisposition' => 'attachment;',
                    ]
                );
                $request = $s3Client->createPresignedRequest($command, '+1440 minutes');

                return (string)$request->getUri();
            }

            return $defaultImage;
        } catch (S3Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());

            return $defaultImage;
        }
    }

    public function deleteFileFromS3($path):void
    {
        $disk = Storage::disk('s3');
        if ($disk->exists($path)) {
            Storage::disk('s3')->delete($path);
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
