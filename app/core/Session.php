<?php


class Session
{
    public function writeToSession($data)
    {
        $_SESSION=$data;
    }
}