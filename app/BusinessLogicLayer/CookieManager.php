<?php

namespace App\BusinessLogicLayer;

class CookieManager {

    public static function deleteCookie(string $cookieKey) {
        setcookie($cookieKey, false);
        unset($_COOKIE[$cookieKey]);
    }

}
