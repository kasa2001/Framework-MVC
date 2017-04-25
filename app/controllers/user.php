<?php

/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 25.04.2017
 * Time: 19:07
 */
class User extends Controller
{
    public function index(){

    }

    public function login(){
        $user = $this->loadModel('User');
        $css = "main user";
        $js = "main";
        $this->view('home/index', NULL, $css, $js);
    }
}