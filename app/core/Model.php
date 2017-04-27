<?php


class Model extends Database
{
    protected $connection;
    protected $table;
    protected $columns = [];
    protected $type;

    public function __construct($table, $columns = [],$data = [])
    {
        /*
         * Construct in test.
         * */
        $this->connection = new Database();
        $this->columns=$columns;
        $this->table=$table;
//        $this->connection->query = $this->createQuery($this->table, 1, array_merge($this->columns, $this->connection->data),"a");
//        $this->connection->query= $this->modifyWhere($this->connection->query,$data,"a");
//        $this->connection->data = $this->connection->request($this->connection->connect);
//        $this->connection->getResultRequest();
//        print_r($_SESSION);

    }

}