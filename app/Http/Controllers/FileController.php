<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller {
    public function uploadFiles(Request $request): JsonResponse {
        $request->validate([
            'files.*' => 'required|file|max:52428800|mimetypes:image/*,audio/,video/*,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf',
        ]);
        $responseFilePaths = [];
        foreach ($request->files as $fileObject) {
            $symfonyFile = $fileObject[0];
            $uploadedFile = UploadedFile::createFromBase($symfonyFile);
            $originalFileName = $uploadedFile->getClientOriginalName();
            $path = Storage::disk('s3')->put('uploads', $uploadedFile);
            $uploadedFilePath = Storage::disk('s3')->url($path);
            $responseFilePaths[$originalFileName] = $uploadedFilePath;
        }

        return response()->json($responseFilePaths);
    }
}
