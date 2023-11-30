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
            'files' => 'max:8', //maximum number of files: 5
            'project_id' => 'required|int',
            'questionnaire_id' => 'required|int',
        ]);
        $responseFilePaths = [];
        Log::info("Uploading files: " . count($request->file('files')));

        foreach ($request->file('files') as $fileObject) {
            $uploadedFile = UploadedFile::createFromBase($fileObject);
            $originalFileName = $uploadedFile->getClientOriginalName();
            $path = Storage::disk('s3')->put('uploads/project_' . $request->project_id . '/questionnaire_' . $request->questionnaire_id, $uploadedFile);
            $uploadedFilePath = Storage::disk('s3')->url($path);
            $responseFilePaths[$originalFileName] = $uploadedFilePath;
        }
        return response()->json($responseFilePaths);
    }
}
