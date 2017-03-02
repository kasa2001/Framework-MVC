<?php

/**
 * Class supports MySQL only.
 * */
class Database
{
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
    public function __construct($base, $server = 'localhost', $login = 'root', $password = "")
    {
        $this->server = $server;
        $this->login = $login;
        $this->password = $password;
        $this->base = $base;
        $this->connect = new mysqli($this->server, $this->login, $this->password, $this->base);
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
    public function createQuery($table, $choose, $modify = 0, $data = [], $sort = 0)
    {
        switch ($choose) {
            case 1:
                return $this->createSelectQuery($table, $modify, $data, $sort);
            case 2:
                return $this->createInsertQuery($table, $data);
            case 3:
                return $this->createDeleteQuery($table, $modify, $data);
            case 4:
                return $this->createUpdateQuery($table, $modify, $data);
            default:
                echo 'Bad choose query. Check second param in call method createQuery()';
        }
        return NULL;
    }

    public function createSelectQuery($table, $modify, $data = [], $sort)
    {
        $query = "SELECT * FROM `" . $table . "` ";
        if ($modify) {
            $sort != 0? $i = 1:$i = 0;
            $n = count($data);
            if ($i < $n) $query = $this->where($query, $i, $n, $data, $modify);
            else if ($i > $n) return $this->warning();
        }
        if ($sort) $query=$this->sort($query,$data,$sort);
        return $query;
    }

    public function sort($query, $data, $sort){
        $query .= "ORDER BY `" . $data[0];
        $sort == 1? $query .= "` ASC":$query .= "` DESC";
        return $query;
    }

    public function createDeleteQuery($table, $modify, $data = [])
    {
        $query = "DELETE FROM `" . $table . "` ";
        $i = 0;
        $n = count($data);
        if ($i > $n) return $this->warning();
        $query = $this->where($query, $i, $n, $data, $modify);
        return $query;
    }

    public function createUpdateQuery($table, $modify, $data)
    {
        $query = "UPDATE `" . $table . "` SET `" . $data[0] . "` = '" . $data[1] . "' ";
        $query = $this->where($query, 2, count($data), $data, $modify);
        return $query;
    }

    /**
     * Function which add to query WHERE
     * @param $query string. It is a query
     * @param $i integer. It is a control param
     * @param $n integer. It is a size of array $data
     * @param $data array string. Is is a data to transfer to query
     * @param $modify
     * @return string $query
     * */
    public function where($query, $i, $n, $data = [], $modify)
    {
        $query .= "WHERE `";
        for (; $i < $n; $i += 2) {
            if ($i + 1 == $n) return $this->warning();
            else {
                $query .= $data[$i] . "` = '" . $data[$i + 1] . "' ";
                if (($i + 1) < ($n - 1) and $modify == 1) $query .= "AND `";
                else if (($i + 1) < ($n - 1) and $modify > 1) $query .= "OR `";
            }
        }
        return $query;
    }

    public function modifyWhere($query, $data = [], $modify="a")
    {
        if (count($data) % 2 == 1) {
            echo 'Warning: In called function orWhere() array elements is not even. Check array';
            return NULL;
        }
        $find = 0;
        $index = 0;
        $table = explode(" ", $query);
        for ($i = 0; $i < (count($table)); $i++) {
            if ($table[$i] == "WHERE") {
                $find = 1;
            }
            if ((!isset($table[$i+1])) or $table[$i + 1] == "ORDER" ) {
                if ($find) {
                    if ($data) {
                        if ((isset($table[$i+1])) and $table[$i + 1] == "ORDER") {
                            $table[$i + 5] = $table[$i + 1];
                            $table[$i + 6] = $table[$i + 2];
                            $table[$i + 7] = $table[$i + 3];
                            $table[$i + 8] = $table[$i + 4];
                        }
                        if ($modify=="a"){
                            $table[$i+1]="AND";
                        }else if ($modify=="o"){
                            $table[$i + 1] = 'OR';
                        }
                        $table[$i + 2] = "`" . $data[$index] . "`";
                        $table[$i + 3] = "=";
                        $table[$i + 4] = "'" . $data[$index + 1] . "'";
                        unset($data[$index]);
                        unset($data[$index + 1]);
                        $index += 2;
                    } else {
                        return implode(" ", $table);
                    }
                } else {
                    echo 'Warning: WHERE is not exists in query. Create WHERE calling function createQuery()';
                    return NULL;
                }
            }
        }
        return implode(" ", $table);
    }

    public function createInsertQuery($table, $data = [])
    {
        $query = "INSERT INTO `" . $table . "` ( ";
        $n = count($data);
        if ($n % 2 != 0) {
            echo "Warning: param n is not even. Check data array in function createQuery()";
            return NULL;
        }
        $query = $this->columns($query, 0, $n,$data);
        $query .= ") VALUES (";
        $query = $this->values($query, ($n/2), $n,$data);
        $query .= ");";
        return $query;
    }

    public function columns($query, $i, $n, $data=[]){
        for (; $i < ($n / 2); $i++) {
            $query .= "`" . $data[$i] . "`";
            if (($i) != (($n / 2) - 1)) {
                $query .= ", ";
            }
        }
        return $query;
    }

    public function values($query, $i, $n, $data=[]){
        for (; $i < $n; $i++) {
            $query .= "'" . $data[$i] . "'";
            if (($i) != ($n - 1)) {
                $query .= ", ";
            }
        }
        return $query;
    }

    public function warning(){
        echo 'Warning: Too small array in call method createQuery()';
        return NULL;
    }

    /**
     * Function which send query to database and get result query
     * @param $connect Database data about connection
     * @return object array (return score of $query)
     * */
    public function request($connect)
    {
        return $connect->query($this->query);
    }
}