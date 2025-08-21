<?php

declare(strict_types=1);

namespace App\Utils;

class Helpers {
    public static function getFilteredAttributes(array $attributes, array $allowedKeys): array {
        return array_filter(
            $attributes,
            fn ($key): bool => in_array($key, $allowedKeys),
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * Checks if the value is not empty
     *
     * @param  $value  mixed
     *
     * @return bool whether the value is not empty
     */
    public static function HTMLValueIsNotEmpty(mixed $value): bool {
        return $value && $value !== '<p><br></p>'
            && $value !== '<p><br></p><p><br></p>'
            && $value !== '<p>&nbsp;</p>';
    }
}
