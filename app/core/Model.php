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
        $data[0]='Id';
        $data[1]='Nick';
        $data[2]='EMAIL';
        $data[3]='PASSWORD';
        $data[4]='NULL';
        $data[5]='kozłowski';
        $data[6]='mietek';
        $data[7]='kozłowski';
        $this->connection->query = $this->createQuery($this->table->table,2,1,$data,2);
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