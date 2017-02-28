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
        $this->inquiry = $this->createInquiry($this->table->table,1);
        $this->data = $this->request($this->connection);
        echo $this->data;
    }

    public function tableName($model){
        require_once '../app/models/table/'.$model.'Table.php';
        $this->table=new UserTable();
    }

}