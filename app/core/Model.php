<?php


class Model extends Database {
    protected $connection;
    public function __construct()
    {
        /*
         * Function in test. If you download this framework change inquiry there
         *
         * */
        $this->connection = new Database("projekt");
        $this->data = $this->connection->request($this->connection->connect,"SELECT * FROM `users` WHERE `Nick` = 'Marianek'");
        print_r($this->data);
    }

}