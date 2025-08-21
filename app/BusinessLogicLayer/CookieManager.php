<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer;

use Illuminate\Support\Facades\Cookie;

class CookieManager {
    public function deleteCookie(string $cookieKey): void {
        Cookie::queue(Cookie::forget($cookieKey));
        if (isset($_COOKIE[$cookieKey])) {
            unset($_COOKIE[$cookieKey]);
        }
    }

    public function getCookie(string $cookieKey): mixed {
        return Cookie::get($cookieKey) ?? $_COOKIE[$cookieKey] ?? null;
    }
}
