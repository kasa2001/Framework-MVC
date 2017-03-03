<?php

/**
 * All new classes must extends which class Controller. You can in this moment profit a function included in framework
 * */
class Home extends Controller
{
    public function index($name = '')
    {
//        $user = new model('User');
        $css = "main home";
        $js = "main home";
        $this->view('home/index', NULL, $css, $js);
    }
}