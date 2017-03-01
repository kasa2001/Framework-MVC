<?php
/**
 * Class supports MySQL only.
 * */
class Database{
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
     * @return string table (return score of $inquiry)
     * */
    public function request($connect){
        return $connect->query($this->inquiry);
    }
    /**
     * Function which create a new inquiry
     * @param $table string data about load table
     * @param $choose integer select type of inquiry
     * @return string return generated inquiry
     */
    public function createInquiry($table, $choose){
        switch ($choose){
            case 1:
                return "SELECT * FROM `".$table."`";
            case 2:
                return "INSERT INTO `".$table."` VALUES ('NULL','mietek','mietek@mietek.com','jakies')";
            case 3:
                return "DELETE FROM `".$table."` WHERE `Nick` = 'mietek'";
            case 4:
                return "UPDATE `".$table."` SET `Nick` = 'miete' WHERE `Nick` = 'mietek';";
                break;
            default:
                echo 'Bad choose inquiry. Check second param in call method';

        }
        return NULL;
    }
}