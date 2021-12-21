<?php

namespace App\BusinessLogicLayer;

use Illuminate\Support\Facades\Cookie;

class CookieManager {

    public static function deleteCookie(string $cookieKey) {
        Cookie::queue(Cookie::forget($cookieKey));
        //setcookie($cookieKey, false);
        //unset($_COOKIE[$cookieKey]);
    }

}
