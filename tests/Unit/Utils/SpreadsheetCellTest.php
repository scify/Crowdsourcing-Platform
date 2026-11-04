<?php

declare(strict_types=1);

namespace Tests\Unit\Utils;

use App\Utils\SpreadsheetCell;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SpreadsheetCellTest extends TestCase {
    #[Test]
    public function text_that_starts_with_a_formula_character_is_prefixed(): void {
        $this->assertSame(
            ["'=HYPERLINK(\"https://evil.example\")", "'+1", "'-1+1", "'@SUM(A1)", "'\tx", "'\rx"],
            SpreadsheetCell::csvRow(['=HYPERLINK("https://evil.example")', '+1', '-1+1', '@SUM(A1)', "\tx", "\rx"])
        );
    }

    #[Test]
    public function other_values_are_unchanged(): void {
        $this->assertSame(
            ['An answer', 42, -3, null, '', 'a=b'],
            SpreadsheetCell::csvRow(['An answer', 42, -3, null, '', 'a=b'])
        );
    }
}
