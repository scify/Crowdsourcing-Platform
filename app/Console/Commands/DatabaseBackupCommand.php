<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class DatabaseBackupCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a database backup and manage backup rotation';

    /**
     * Execute the console command.
     */
    public function handle(): int {
        $this->info('Starting database backup...');

        // Get database configuration
        $connection = config('database.default');
        $database = config(sprintf('database.connections.%s.database', $connection));
        $username = config(sprintf('database.connections.%s.username', $connection));
        $password = config(sprintf('database.connections.%s.password', $connection));
        $host = config(sprintf('database.connections.%s.host', $connection));

        // Create backup directory if it doesn't exist
        $backupPath = storage_path('app/backups');
        if (! file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        // Generate backup filename with timestamp
        $timestamp = Carbon::now()->format('Y-m-d_H-i');
        $filename = sprintf('backup_%s_%s.sql', $database, $timestamp);
        $filepath = sprintf('%s/%s', $backupPath, $filename);

        // Create backup using mysqldump
        $mysqldumpPath = '/usr/bin/mysqldump';
        if (app()->environment('production')) {
            $mysqldumpPath = '/opt/bitnami/mariadb/bin/mysqldump';
        }

        $command = sprintf(
            'MYSQL_PWD=%s %s -h %s -u %s %s > %s 2>&1',
            escapeshellarg((string) $password),
            $mysqldumpPath,
            escapeshellarg((string) $host),
            escapeshellarg((string) $username),
            escapeshellarg((string) $database),
            escapeshellarg($filepath)
        );

        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            $this->error('Backup failed! Command: ' . $command);
            $this->error(implode("\n", $output));

            return 1;
        }

        $this->info('Backup created successfully: ' . $filename);

        // Rotate backups - keep only the last 30
        $this->rotateBackups($backupPath);

        return 0;
    }

    private function rotateBackups(string $backupPath): void {
        $files = glob($backupPath . '/backup_*.sql');

        if (count($files) > 30) {
            // Sort files by modification time
            usort($files, fn ($a, $b): int => filemtime($a) - filemtime($b));

            // Remove oldest files
            $filesToDelete = array_slice($files, 0, count($files) - 30);
            foreach ($filesToDelete as $fileToDelete) {
                unlink($fileToDelete);
                $this->info('Removed old backup: ' . basename($fileToDelete));
            }
        }
    }
}
