<?php

namespace App\BusinessLogicLayer;

use Illuminate\Support\Facades\Cookie;

class CookieManager {
    public static function deleteCookie(string $cookieKey): void {
        Cookie::queue(Cookie::forget($cookieKey));
        if (isset($_COOKIE[$cookieKey])) {
            unset($_COOKIE[$cookieKey]);
        }
    }

    public static function getCookie(string $cookieKey): mixed {
        return Cookie::get($cookieKey) ?? $_COOKIE[$cookieKey] ?? null;
    }
}
