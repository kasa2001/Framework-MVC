<?php


class Model extends Database
{
    protected $table;
    protected $columns = [];

    public function __construct($table, $columns = [],$data = [])
    {
        parent::__construct();
        $this->columns=$columns;
        $this->table=$table;
        $this->query = $this->createQuery($this->table, "select", array_merge($this->columns, $this->data),"a");
//        $this->connection->data = $this->connection->request($this->connection->connect);
//        $this->connection->result = $this->connection->getResultRequest();
//        print_r($this->query);
//        print_r($this->connection->result);

    }

}