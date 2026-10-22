<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;

class FileController extends Controller {
    public function uploadFiles(Request $request): JsonResponse {
        $request->validate([
            'files.*' => 'required|file|max:5120|mimetypes:image/*,audio/,video/*,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf',
            'files' => 'max:8', // maximum number of files: 8
        ]);
        $responseFilePaths = [];

        foreach ($request->file('files') as $fileObject) {
            $uploadedFile = UploadedFile::createFromBase($fileObject);
            $originalFileName = $uploadedFile->getClientOriginalName();
            $uniqueId = Str::uuid(); // Generate a unique ID for each file

            if (Str::startsWith($uploadedFile->getMimeType(), 'image/')) {
                // Load the image
                $image = ImageManager::usingDriver(GdDriver::class)->decodePath($uploadedFile->getPathname());

                // Shrink to a max width of 1024, keeping the aspect ratio
                // (scaleDown never upscales smaller images)
                $image->scaleDown(width: 1024);

                // Compress and save the processed image to a temporary file
                $tempPath = sys_get_temp_dir() . '/' . $uniqueId . '.jpg';
                $image->encodeUsingMediaType('image/jpeg', quality: 90)->save($tempPath);

                // Upload the processed image to S3
                $path = Storage::disk('s3')->putFileAs('uploads', new File($tempPath), $uniqueId . '.jpg');
                unlink($tempPath); // Delete the temporary file
            } else {
                // Upload non-image files directly
                $path = Storage::disk('s3')->put('uploads/' . $uniqueId, $uploadedFile);
            }

            $uploadedFilePath = Storage::disk('s3')->url($path);
            $responseFilePaths[$originalFileName] = $uploadedFilePath;
        }

        return response()->json($responseFilePaths);
    }
}
