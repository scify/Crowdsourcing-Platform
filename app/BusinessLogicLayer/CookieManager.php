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
}
