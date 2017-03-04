<?php

class Config
{
    protected $config;

    private $path='../app/config/config.ini';

    public function __construct()
    {
        if (file_exists($this->path) and (filesize($this->path) !== 0)) {
            $this->config=parse_ini_file($this->path,true);
        }
    }
}
