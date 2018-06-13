<?php

namespace App\BusinessLogicLayer;


use Cocur\Slugify\Slugify;

class Utils {

    static public function slugify($string)
    {
        $slugify = new Slugify();

        return $slugify->slugify($string);
    }

}