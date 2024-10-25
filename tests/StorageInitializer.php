<?php

namespace Tests;

class StorageInitializer {
    private static string $lockFilePath;

    public static function initialize(): void {
        // Use the storage_path() helper function directly
        self::$lockFilePath = storage_path('storage/storage_initialized.lock');

        // Ensure the directory for the lock file exists
        $lockFileDir = dirname(self::$lockFilePath);
        if (!is_dir($lockFileDir)) {
            mkdir($lockFileDir, 0777, true);
        }

        // Use a lock file to ensure initialization only happens once
        $lockFile = fopen(self::$lockFilePath, 'c');
        if (!$lockFile) {
            throw new \RuntimeException('Failed to create or open the lock file: ' . self::$lockFilePath);
        }

        // Acquire an exclusive lock
        if (!flock($lockFile, LOCK_EX)) {
            fclose($lockFile);
            throw new \RuntimeException('Failed to acquire the lock for initialization.');
        }

        // Check if the storage directories already exist
        if (!self::storageDirectoriesExist()) {
            // Create the storage directories if they don't exist
            self::createStorageDirectories();

            // Create the lock file to signal that initialization is complete
            touch(self::$lockFilePath);
        }

        // Release the lock and close the file
        flock($lockFile, LOCK_UN);
        fclose($lockFile);
    }

    private static function storageDirectoriesExist(): bool {
        // Check if the main storage directory and user profile image path exist
        $storagePath = storage_path('app');
        $userProfileImgPath = $storagePath . '/public/uploads/user_profile_img';

        return is_dir($storagePath) && is_dir($userProfileImgPath);
    }

    private static function createStorageDirectories() {
        $storagePath = storage_path('app');
        if (!is_dir($storagePath)) {
            if (!mkdir($storagePath, 0777, true) && !is_dir($storagePath)) {
                throw new \RuntimeException("Failed to create the directory: {$storagePath}");
            }
        }

        $userProfileImgPath = $storagePath . '/public/uploads/user_profile_img';
        if (!is_dir($userProfileImgPath)) {
            if (!mkdir($userProfileImgPath, 0777, true) && !is_dir($userProfileImgPath)) {
                throw new \RuntimeException("Failed to create the directory: {$userProfileImgPath}");
            }
        }
    }
}
