<?php

namespace Tests\Feature\Controllers;

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileControllerTest extends TestCase {
    /** @test */
    public function uploadFilesSuccessfullyUploadsFiles() {
        Storage::fake('s3');
        $files = [
            UploadedFile::fake()->image('photo1.jpg'),
            UploadedFile::fake()->image('photo2.jpg'),
        ];

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson('/files/upload', [
                'files' => $files,
                'project_id' => 1,
                'questionnaire_id' => 1,
            ]);

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $filePaths = $response->json();
        foreach ($filePaths as $filePath) {
            $relativePath = str_replace(Storage::disk('s3')->url(''), '', $filePath);
            Storage::disk('s3')->assertExists($relativePath);
        }
    }

    /** @test */
    public function uploadFilesFailsWithInvalidFileType() {
        Storage::fake('s3');
        $files = [
            UploadedFile::fake()->create('document.txt', 100),
        ];

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson('/files/upload', [
                'files' => $files,
                'project_id' => 1,
                'questionnaire_id' => 1,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['files.0']);
    }

    /** @test */
    public function uploadFilesFailsWithTooManyFiles() {
        Storage::fake('s3');
        $files = array_fill(0, 9, UploadedFile::fake()->image('photo.jpg'));

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson('/files/upload', [
                'files' => $files,
                'project_id' => 1,
                'questionnaire_id' => 1,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['files']);
    }

    /** @test */
    public function uploadFilesFailsWithoutProjectId() {
        Storage::fake('s3');
        $files = [
            UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson('/files/upload', [
                'files' => $files,
                'questionnaire_id' => 1,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['project_id']);
    }

    /** @test */
    public function uploadFilesFailsWithoutQuestionnaireId() {
        Storage::fake('s3');
        $files = [
            UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson('/files/upload', [
                'files' => $files,
                'project_id' => 1,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['questionnaire_id']);
    }
}
