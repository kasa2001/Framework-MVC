<?php

class Cookies
{
    public function __construct($name, $value, $time = null)
    {
        if ($time==null)
            setcookie($name, $value);
        else
            setcookie($name, $value, $time);
    }

    public function getFromCookies($data)
    {
        return $_COOKIE[$data];
    }

    public function destroyCookies($name)
    {
        unset($_COOKIE[$name]);
    }

    public function changeCookieValue($name, $value){
        setcookie($name, $value);
    }
}