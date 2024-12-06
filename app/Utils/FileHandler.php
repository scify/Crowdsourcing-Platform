<?php

namespace App\Utils;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * Class FileUploader
 */
class FileHandler {
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

    public static function deleteUploadedFile(string $filePath, string $directoryName = ''): void {
        $fileName = explode('/', $filePath);
        $filePath = storage_path('app/public/uploads/' . $directoryName . '/' . end($fileName));
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public static function copyFile(string $filePath, string $dirName): string {
        $fileName = explode('/', $filePath);
        // get the file name
        $fileName = end($fileName);
        // add a timestamp to the file name to avoid conflicts
        $fileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . time() . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

        // if the file starts with "/images", it means that it is located in the public directory
        if (starts_with($filePath, '/images')) {
            $filePath = public_path($filePath);
        } else {
            $filePath = storage_path($fileName);
        }
        $path = 'app/public/uploads/' . $dirName . '/' . $fileName;
        $newFilePath = storage_path($path);
        copy($filePath, $newFilePath);

        return '/storage/uploads/' . $dirName . '/' . $fileName;
    }
}
