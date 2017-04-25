<?php

class User extends Controller
{
    public function index()
    {

    }

    public function login()
    {
        $user = $this->loadModel('User');
        $css = "main user";
        $js = "main";
        $this->view('user/login', NULL, $css, $js);
    }
}