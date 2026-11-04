<?php

declare(strict_types=1);

namespace App\Utils;

class SpreadsheetCell {
    /**
     * Characters that make Excel and LibreOffice read a cell as a formula.
     */
    private const array FORMULA_TRIGGERS = ['=', '+', '-', '@', "\t", "\r"];

    /**
     * Prepares a row of user-supplied values for a CSV export.
     * A text value that starts with a formula character gets a leading "'",
     * so a spreadsheet program shows it as text and does not run it.
     */
    public static function csvRow(array $values): array {
        return array_map(self::csvValue(...), $values);
    }

    public static function csvValue(mixed $value): mixed {
        if (is_string($value) && $value !== '' && in_array($value[0], self::FORMULA_TRIGGERS, true)) {
            return "'" . $value;
        }

        return $value;
    }
}
