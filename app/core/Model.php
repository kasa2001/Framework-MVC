<?php


class Model extends Database {
    protected $connection;
    protected $table;
    protected $type;
    public function __construct($model)
    {
        /*
         * Function in test. If you download this framework change query there
         * */
        $this->connection = new Database("projekt");
        $this->tableName($model);
        $data[0]='Nick';
        $data[1]='zenon';
        $data[2]='Nick';
        $data[3]='Ziutek';
        $data[4]='Nick';
        $data[5]='Ziutek';
        $this->connection->query = $this->createQuery($this->table->table,4,0,$data,2);
        $this->data = $this->connection->request($this->connection->connect);
        print_r($this->connection->query);
    }

    public function tableName($model){
        require_once '../app/models/table/'.$model.'Table.php';
        $this->table=new UserTable();
    }
    public function typeOfQuery($type){
        return $type;
    }

}