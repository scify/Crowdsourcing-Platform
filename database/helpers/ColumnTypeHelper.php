<?php

namespace Database\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ColumnTypeHelper {
    public static function getColumnType(string $tableName, string $columnName): string {
        $connection = Config::get('database.default');
        $databaseName = Config::get("database.connections.$connection.database");

        if ($connection === 'sqlite' || $connection === 'sqlite_testing') {
            $result = DB::select("
                PRAGMA table_info($tableName)
            ");
            foreach ($result as $column) {
                if ($column->name === $columnName) {
                    return $column->type;
                }
            }
        } else {
            return DB::selectOne('
                SELECT DATA_TYPE
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = ?
                AND TABLE_NAME = ?
                AND COLUMN_NAME = ?
            ', [$databaseName, $tableName, $columnName])->DATA_TYPE;
        }

        throw new \Exception("Column $columnName not found in table $tableName");
    }
}
