<?php

namespace Database\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ColumnTypeHelper {
    public static function getColumnType(string $tableName, string $columnName): string {
        $databaseName = Config::get('database.connections.mysql.database');

        return DB::selectOne('
            SELECT DATA_TYPE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = ?
            AND TABLE_NAME = ?
            AND COLUMN_NAME = ?
        ', [$databaseName, $tableName, $columnName])->DATA_TYPE;
    }
}
