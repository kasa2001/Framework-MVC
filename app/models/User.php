<?php

/**
 * All new classes must extends which class Model. You can in this moment profit a function included in framework
 * */
class User extends Model{

    /**
     * Function in model must return name table
     * @return string return table name
     * */
    public function table(){
        return "users";
    }
}