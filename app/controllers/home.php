<?php

/**
 * All new classes must extends which class Controller. You can in this moment profit a method included in framework
 * */
class Home extends Controller
{
    public function index($name = '')
    {
        $user = $this->loadModel('User');
        $css = "main home";
        $js = "main home";
        $this->view('home/index', NULL, $css, $js);
    }

    public function error()
    {
        $this->view("home/error", NULL);
    }
}