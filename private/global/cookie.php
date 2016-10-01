<?php

class Cookie {

    public static function set($name, $value = "", $expires = 0, $path = "/", $domain = "", $secure = false, $httponly = false) {
//        if (!$domain) {
//            $domain = "." . $_SERVER["HTTP_HOST"];
//        }
        $current = time();
        if ($current <= $expires || $expires==0) {
            $_COOKIE[$name] = $value;
        }
        if ($value == "") {
            unset($_COOKIE[$name]);
        }
        return setcookie($name, $value, $expires, $path, $domain, $secure, $httponly);
    }

    public static function get($name) {
        return $_COOKIE[$name];
    }

    public static function deleteCookie($name) {
        unset($_COOKIE[$name]);
        return setcookie($name, "", time() - 86400);
    }

}
