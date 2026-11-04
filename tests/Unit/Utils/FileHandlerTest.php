<?php

declare(strict_types=1);

namespace Tests\Unit\Utils;

use App\Utils\FileHandler;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class FileHandlerTest extends TestCase {
    protected function tearDown(): void {
        $directory = storage_path('app/public/uploads/file_handler_test');
        array_map(unlink(...), glob($directory . '/*') ?: []);
        if (is_dir($directory)) {
            rmdir($directory);
        }

        parent::tearDown();
    }

    /**
     * GIVEN a JPEG image with an ".html" file name
     * WHEN it is uploaded
     * THEN it is stored with the ".jpg" extension of its content
     */
    #[Test]
    public function stored_extension_comes_from_the_file_content(): void {
        $path = FileHandler::uploadAndGetPath($this->jpegNamed('probe.html'), 'file_handler_test');

        $this->assertStringEndsWith('.jpg', $path);
        $this->assertStringStartsWith('/storage/uploads/file_handler_test/probe_', $path);
    }

    /**
     * GIVEN a PHP script with an image file name
     * WHEN it is uploaded
     * THEN it is rejected
     */
    #[Test]
    public function non_image_file_is_rejected(): void {
        $tmp = tempnam(sys_get_temp_dir(), 'fh');
        file_put_contents($tmp, '<?php echo "x";');

        $this->expectException(InvalidArgumentException::class);

        FileHandler::uploadAndGetPath(new UploadedFile($tmp, 'logo.png', null, null, true), 'file_handler_test');
    }

    private function jpegNamed(string $name): UploadedFile {
        $tmp = tempnam(sys_get_temp_dir(), 'fh');
        $image = imagecreatetruecolor(2, 2);
        imagejpeg($image, $tmp);

        return new UploadedFile($tmp, $name, null, null, true);
    }
}
