<?php
/**
 * Class supports MySQL only.
 * */
class Database {
    protected $server;
    protected $login;
    protected $password;
    protected $base;
    protected $connect;
    protected $inquiry;
    protected $data;

    /**
     * Connect with database
     * @param $base string database
     * @param $server string choose server (implicitly localhost)
     * @param $login  string choose user database (implicitly root)
     * @param $password string write password to database (implicitly NULL)
     */
    public function __construct($base, $server='localhost', $login='root', $password=""){
        $this->server=$server;
        $this->login=$login;
        $this->password=$password;
        $this->base=$base;
        $this->connect= new mysqli($this->server,$this->login, $this->password, $this->base);
    }

    /**
     * Function which send inquiry to database and get result inquiry
     * @param $connect Database data about connection
     * @param $inquiry string inquiry to database
     * @return string table (return score of $inquiry)
     * */
    public function request($connect,$inquiry){
        $this->inquiry=$inquiry;
        $this->data=$connect->query($this->inquiry);
        $check = explode(' ', $inquiry);
        if ($check[0]=='SELECT'){
            return $this->data->fetch_assoc();
        }
        $this->connect->close();
        return NULL;
    }
}