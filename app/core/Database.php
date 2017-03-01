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
    protected $query;
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
     * Function which send query to database and get result query
     * @param $connect Database data about connection
     * @return string table (return score of $query)
     * */
    public function request($connect){
        return $connect->query($this->query);
    }

    public function createInsertQuery($table, $data=[]){
        $query="INSERT INTO `".$table."` ( ";
        $n=count($data);
        if ($n%2!=0){
            echo "Warning: param n is not even. Check table";
            return NULL;
        }
        for($i=0; $i<($n/2); $i++){
            $query=$query."`".$data[$i]."`";
            if (($i)!=(($n/2)-1)){
                $query=$query.", ";
            }
        }
        $query=$query.") VALUES (";
        for($i; $i<$n; $i++){
            $query=$query."'".$data[$i]."'";
            if (($i)!=($n-1)){
                $query=$query.", ";
            }
        }
        $query=$query.");";
        return $query;
    }

    public function createSelectQuery($table, $modify, $data=[], $sort){
        $temp=0;
        $i=0;
        $query="SELECT * FROM `".$table."` ";
        if ($modify!=0){
            if ($sort!=0){
                $temp=1;
                $i=1;
            }
            $n=count($data);
            if ($i==$n){

            }else if ($i<$n){
                $query=$query."WHERE `";
            }else if ($i>$n){
                echo 'Warning: Too small table in call function createQuery()';
                return NULL;
            }
            for ($i; $i<$n;$i+=2){
                if ($i+1==$n){
                    echo 'Warning: Too small table in call function createQuery() Check query: ';
                    return $query;
                }else{
                    $query=$query.$data[$i]."` = '".$data[$i+1]."' ";
                    if (($i+1)<($n-1)){
                        $query=$query."AND `";
                    }
                }
            }
        }
        if ($temp){
            $query=$query."ORDER BY `".$data[0];
            if ($sort==1){
                $query=$query."` ASC";
            }else if ($sort==2){
                $query=$query."` DESC";
            }
        }
        return $query;
    }



    /**
     * Function which create a new query
     * @param $table string data about load table
     * @param $choose integer select type of query (1 SELECT, 2 INSERT, 3 DELETE, 4 UPDATE)
     * @param $modify integer degree modify the query (implicitly 0)
     * @param $data (table string) additional data (implicitly empty table)
     * @param $sort integer sort score query (implicitly 0)
     * @return string return generated query
     */
    public function createQuery($table, $choose, $modify=0,$data=[], $sort=0){
        $query=NULL;
        switch ($choose){
            case 1:
                return $this->createSelectQuery($table,$modify,$data,$sort);
            case 2:
                return $this->createInsertQuery($table,$data);
            case 3:
                return "DELETE FROM `".$table."` WHERE `Nick` = 'mietek'";
            case 4:
                return "UPDATE `".$table."` SET `Nick` = 'miete' WHERE `Nick` = 'mietek';";
                break;
            default:
                echo 'Bad choose query. Check second param in call method';
        }
        return $query;
    }
}