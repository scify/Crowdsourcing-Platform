<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller {
    public function uploadFiles(Request $request): JsonResponse {
        $request->validate([
            'files.*' => 'required|file|max:100000|mimetypes:image/*,audio/,video/*,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf',
            'files' => 'max:8', // maximum number of files: 8
            'project_id' => 'required|int',
            'questionnaire_id' => 'required|int',
        ]);
        $responseFilePaths = [];

        foreach ($request->file('files') as $fileObject) {
            $uploadedFile = UploadedFile::createFromBase($fileObject);
            $originalFileName = $uploadedFile->getClientOriginalName();
            $uniqueId = Str::uuid(); // Generate a unique ID for each file
            $path = Storage::disk('s3')->put('uploads/' . $uniqueId, $uploadedFile);
            $uploadedFilePath = Storage::disk('s3')->url($path);
            $responseFilePaths[$originalFileName] = $uploadedFilePath;
        }

        return response()->json($responseFilePaths);
    }
}
