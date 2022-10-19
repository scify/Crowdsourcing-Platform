<?php

namespace App\Utils;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class FileUploader {
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
