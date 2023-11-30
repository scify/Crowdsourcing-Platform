<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller {
    public function uploadFiles(Request $request): JsonResponse {
        $request->validate([
            'files.*' => 'required|file|max:52428800|mimetypes:image/*,audio/,video/*,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf',
            'project_id' => 'required|int',
            'questionnaire_id' => 'required|int',
        ]);
        $responseFilePaths = [];
        Log::info($request);
        Log::info($request->files);
        Log::info($request->file('files'));
        Log::info("Uploading files: " . count($request->files));

        foreach ($request->files as $fileObject) {
            Log::info("New file");
            $symfonyFile = $fileObject[0];
            Log::info($symfonyFile);
            $uploadedFile = UploadedFile::createFromBase($symfonyFile);
            Log::info($uploadedFile);
            $originalFileName = $uploadedFile->getClientOriginalName();
            Log::info($originalFileName);
            $path = Storage::disk('s3')->put('uploads/project_' . $request->project_id . '/questionnaire_' . $request->questionnaire_id, $uploadedFile);
            Log::info($path);
            $uploadedFilePath = Storage::disk('s3')->url($path);
            $responseFilePaths[$originalFileName] = $uploadedFilePath;
        }
        Log::info($responseFilePaths);
        return response()->json($responseFilePaths);
    }
}
