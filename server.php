<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @author   Taylor Otwell <taylor@laravel.com>
 */
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/') {
    $publicDir = realpath(__DIR__ . '/public');
    $requestedFile = realpath(__DIR__ . '/public' . $uri);

    // Check if the requested file exists and is within the public directory
    if ($requestedFile &&
        strpos($requestedFile, $publicDir) === 0 &&
        file_exists($requestedFile)) {
        return false;
    }
}

require_once __DIR__ . '/public/index.php';
