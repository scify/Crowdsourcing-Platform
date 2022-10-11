<?php

namespace App\Utils;

class Helpers {
    public static function getFilteredAttributes(array $attributes, array $allowedKeys): array {
        return array_filter(
            $attributes,
            function ($key) use ($allowedKeys) {
                return in_array($key, $allowedKeys);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}
