<?php

namespace Tests\Feature\Controllers;

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileControllerTest extends TestCase {
    /** @test */
    public function upload_files_successfully_uploads_files() {
        Storage::fake('s3');
        $files = [
            UploadedFile::fake()->image('photo1.jpg'),
            UploadedFile::fake()->image('photo2.jpg'),
        ];

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson('/api/files/upload', [
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
    public function upload_files_fails_with_invalid_file_type() {
        Storage::fake('s3');
        $files = [
            UploadedFile::fake()->create('document.txt', 100),
        ];

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson('/api/files/upload', [
                'files' => $files,
                'project_id' => 1,
                'questionnaire_id' => 1,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['files.0']);
    }

    /** @test */
    public function upload_files_fails_with_too_many_files() {
        Storage::fake('s3');
        $files = array_fill(0, 9, UploadedFile::fake()->image('photo.jpg'));

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson('/api/files/upload', [
                'files' => $files,
                'project_id' => 1,
                'questionnaire_id' => 1,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['files']);
    }

    /** @test */
    public function upload_files_fails_without_project_id() {
        Storage::fake('s3');
        $files = [
            UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson('/api/files/upload', [
                'files' => $files,
                'questionnaire_id' => 1,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['project_id']);
    }

    /** @test */
    public function upload_files_fails_without_questionnaire_id() {
        Storage::fake('s3');
        $files = [
            UploadedFile::fake()->image('photo.jpg'),
        ];

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson('/api/files/upload', [
                'files' => $files,
                'project_id' => 1,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['questionnaire_id']);
    }
}
