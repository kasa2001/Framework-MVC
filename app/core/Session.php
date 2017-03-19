<?php


class Session
{
    public function writeToSession($data)
    {
        $_SESSION=$data;
    }

    public function destroySession(){
        unset($_SESSION);
    }
}