<?php


class Model extends Database
{
    protected $connection;
    protected $table;
    protected $type;

    public function __construct($model)
    {
        /*
         * Construct in test.
         * */
        $this->connection = new Database();
        $this->tableName($model);
        $data[0]='Nick';
        $data[1]='zenon';
        $this->connection->query = $this->createQuery($this->table->table, 1, $data,"a");

        print_r($this->connection->query);
        echo '<br>';

//        $this->connection->query= $this->modifyWhere($this->connection->query,$data,"a");
        $this->connection->data = $this->connection->request($this->connection->connect);
//        $this->connection->getResultRequest();
        print_r($this->connection->data);
        print_r($_SESSION);

    }

    public function tableName($model)
    {
        $model.="Table";
        require_once '../app/models/table/' . $model . '.php';
        $this->table = new $model();
    }

    public function typeOfQuery($type)
    {
        return $type;
    }

}