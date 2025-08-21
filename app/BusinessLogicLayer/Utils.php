<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer;

use Cocur\Slugify\Slugify;

class Utils {
    public static function slugify(string $string): string {
        $slugify = new Slugify;

        return $slugify->slugify($string);
    }
}
