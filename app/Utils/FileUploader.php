<?php

namespace App\Utils;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * Class FileUploader
 */
class FileUploader {
    /**
     * @param UploadedFile $file The file to upload
     * @param string $directoryName The directory name to upload the file to
     * @return string The path of the uploaded file (relative to the storage/app/public directory)
     *
     * This method uploads the file to the server and returns the path of the uploaded file.
     * The path is relative to the storage/app/public directory.
     */
    public static function uploadAndGetPath(UploadedFile $file, string $directoryName = ''): string {
        $originalFileName = Str::slug($file->getClientOriginalName());
        $filePath = pathinfo($originalFileName, PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(storage_path('app/public/uploads/' . $directoryName), $filePath);

        $returnPath = '/storage/uploads/' . $directoryName;
        if ($directoryName !== '') {
            $returnPath .= '/';
        }

        return $returnPath . $filePath;
    }
}
