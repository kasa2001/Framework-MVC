<?php


class Model extends Database {
    protected $connection;
    protected $table;
    public function __construct($model)
    {
        /*
         * Function in test. If you download this framework change inquiry there
         * */
        $this->connection = new Database("projekt");
        $this->tableName($model);
        $this->connection->inquiry = $this->createInquiry($this->table->table,1);
        $this->data = $this->connection->request($this->connection->connect);
        print_r($this->data);
    }

    public function tableName($model){
        require_once '../app/models/table/'.$model.'Table.php';
        $this->table=new UserTable();
    }

}