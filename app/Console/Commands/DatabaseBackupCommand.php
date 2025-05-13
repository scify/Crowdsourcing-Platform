<?php

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
    public function handle() {
        $this->info('Starting database backup...');

        // Get database configuration
        $connection = config('database.default');
        $database = config("database.connections.{$connection}.database");
        $username = config("database.connections.{$connection}.username");
        $password = config("database.connections.{$connection}.password");
        $host = config("database.connections.{$connection}.host");

        // Create backup directory if it doesn't exist
        $backupPath = storage_path('app/backups');
        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        // Generate backup filename with timestamp
        $timestamp = Carbon::now()->format('Y-m-d_H-i');
        $filename = "backup_{$database}_{$timestamp}.sql";
        $filepath = "{$backupPath}/{$filename}";

        // Create backup using mysqldump
        $mysqldumpPath = '/usr/bin/mysqldump';
        if (app()->environment('production')) {
            $mysqldumpPath = '/opt/bitnami/mariadb/bin/mysqldump';
        }
        $command = sprintf(
            'MYSQL_PWD=%s %s -h %s -u %s %s > %s 2>&1',
            escapeshellarg($password),
            $mysqldumpPath,
            escapeshellarg($host),
            escapeshellarg($username),
            escapeshellarg($database),
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

    private function rotateBackups($backupPath) {
        $files = glob($backupPath . '/backup_*.sql');

        if (count($files) > 30) {
            // Sort files by modification time
            usort($files, function ($a, $b) {
                return filemtime($a) - filemtime($b);
            });

            // Remove oldest files
            $filesToDelete = array_slice($files, 0, count($files) - 30);
            foreach ($filesToDelete as $file) {
                unlink($file);
                $this->info('Removed old backup: ' . basename($file));
            }
        }
    }
}
