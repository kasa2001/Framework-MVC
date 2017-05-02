<?php


class Session
{


    public function __construct()
    {
        session_start();
    }

    public function writeToSession($data)
    {
        $_SESSION = $data;
    }

    public function getDataWithSession($data)
    {
        return $_SESSION[$data];
    }

    public function destroySession()
    {
        unset($_SESSION);
    }
}