<?php

class UserTable extends Model
{
    protected $database;
/**
 * Construct create new object -> Model
 * */
    public function __construct()
    {
        $this->database = new Model($this->table(), $this->columns());
    }

    public function table()
    {
        return "users";
    }

    public function columns()
    {
        $columns[0] = 'Id';
        $columns[1] = 'Nick';
        $columns[2] = 'EMAIL';
        $columns[3] = 'PASSWORD';
        return $columns;
    }
}