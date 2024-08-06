<?php

namespace App\BusinessLogicLayer;

use Cocur\Slugify\Slugify;

class Utils {
    public static function slugify($string) {
        $slugify = new Slugify;

        return $slugify->slugify($string);
    }
}
