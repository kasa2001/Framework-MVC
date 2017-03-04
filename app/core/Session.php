<?php


class Session
{
    public function writeToSession($data)
    {
        $_SESSION=$data;
        print_r($_SESSION);
        echo '<br>';
    }
}