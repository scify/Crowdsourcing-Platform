<?php

namespace Tests\Feature\Controllers;

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FileControllerTest extends TestCase {
    #[Test]
    public function upload_files_successfully_uploads_files(): void {
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

    #[Test]
    public function upload_files_fails_with_invalid_file_type(): void {
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

    #[Test]
    public function upload_files_fails_with_too_many_files(): void {
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

    #[Test]
    public function upload_files_fails_without_project_id(): void {
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

    #[Test]
    public function upload_files_fails_without_questionnaire_id(): void {
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
