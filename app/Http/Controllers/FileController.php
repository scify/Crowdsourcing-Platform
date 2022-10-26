<?php

namespace App\Http\Controllers;

use App\Utils\FileUploader;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class FileController extends Controller {
    public function uploadFiles(Request $request): JsonResponse {
        $request->validate([
            'files.*' => 'required|file|max:52428800|mimetypes:image/*,audio/,video/*,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf',
        ]);
        $dirToStoreFileInUploads = $request->directory ?? 'default';
        $responseFilePaths = [];
        foreach ($request->files as $fileObject) {
            $symfonyFile = $fileObject[0];
            $uploadedFile = UploadedFile::createFromBase($symfonyFile);
            $originalFileName = $uploadedFile->getClientOriginalName();
            $uploadedFilePath = config('app.url') . FileUploader::uploadAndGetPath($uploadedFile, $dirToStoreFileInUploads);
            $responseFilePaths[$originalFileName] = $uploadedFilePath;
        }

        return response()->json($responseFilePaths);
    }
}