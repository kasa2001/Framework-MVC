<?php

/**
 * Class supports MySQL only.
 * */
class Database
{
    /**
     * @param $server string. It is a data about server
     * */
    protected $server;

    /**
     * @param $login string. It is a data about database user
     * */
    protected $login;

    /**
     * @param $password string. It is a data about password to database
     * */
    protected $password;

    /**
     * @param $base string. It is a data about database
     * */
    protected $base;

    /**
     * @param $connect object. It is a object class mysqli
     * */
    protected $connect;

    /**
     * @param $query string. It is a data about query
     * */
    protected $query;

    /**
     * @param $server string. It is a data about data to create query
     * */
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
     * @param $data array string. Additional data (implicitly empty array)
     * @param $sort integer sort score query (implicitly 0)
     * @return string return generated query
     */
    public function createQuery($table, $choose, $data = [], $modify = NULL, $sort = 0)
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

    /**
     * Function where create SELECT query
     * @param $table string. Data about table
     * @param $modify
     * @param $data array string. Additional data (implicitly empty array)
     * @param $sort integer. Data about sort
     * @return string. Generated query
     * */
    public function createSelectQuery($table, $modify, $data = [], $sort)
    {
        $query = "SELECT * FROM `" . $table . "` ";
        if ($modify) {
            $sort != 0 ? $i = 1 : $i = 0;
            $n = count($data);
            if ($i < $n) $query = $this->where($query, $i, $n, $data, $modify);
            else if ($i > $n) return $this->warning();
        }
        if ($sort) $query = $this->sort($query, $data, $sort);
        return $query;
    }

    /**
     * Function which add to query data about sort
     * @param $query string. It is a query
     * @param $data array string. Additional data (implicitly empty array)
     * @param $sort integer. Information how sort request
     * @return string. Return query
     * */
    public function sort($query, $data = [], $sort)
    {
        $query .= "ORDER BY `" . $data[0];
        $sort == 1 ? $query .= "` ASC" : $query .= "` DESC";
        return $query;
    }

    /**
     * Function where create DELETE query
     * @param $table string. Data about table
     * @param $modify
     * @param $data array string. Additional data (implicitly empty array)
     * @return string. Return query
     * */
    public function createDeleteQuery($table, $modify, $data = [])
    {
        $query = "DELETE FROM `" . $table . "` ";
        $i = 0;
        $n = count($data);
        if ($i > $n) return $this->warning();
        $query = $this->where($query, $i, $n, $data, $modify);
        return $query;
    }

    /**
     * Function where create UPDATE query
     * @param $table string. Data about table
     * @param $modify
     * @param $data array string. Additional data (implicitly empty array)
     * @return string. Return query
     * */
    public function createUpdateQuery($table, $modify, $data = [])
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
                if (($i + 1) < ($n - 1) and $modify == "a") $query .= "AND `";
                else if (($i + 1) < ($n - 1) and $modify == "o") $query .= "OR `";
                else break;
            }
        }
        return $query;
    }

    /**
     * Function which manipulate query when was generated
     * @param $query string. It is a query
     * @param $data (table string) additional data (implicitly empty array)
     * @param $modify string. It is data how modify query (implicitly "a")
     * @return string. Return query
     */
    public function modifyWhere($query, $data = [], $modify = "a")
    {
        if (count($data) % 2 == 1) return $this->warning();
        $find = $this->searchWhere($query);
        if ($find) $query = $this->mainModify($query, 0, $data, $modify);
        else return $this->warningWhere();
        return $query;
    }

    /**
     * Function which search key word WHERE in query
     * @param $query string. It is a query
     * @return bool. Return true if function found key word or false when not found word WHERE
     * */
    public function searchWhere($query)
    {
        $table = explode(" ", $query);
        for ($i = 0; $i < (count($table)); $i++) {
            if ($table[$i] == "WHERE") {
                $find = true;
                return $find;
            }
        }
        return false;
    }

    /**
     * Function recursively modify query
     * @param $query string. It is a query
     * @param $i integer. It is a control param
     * @param $data array string. Additional data
     * @param $modify string. Data about form of modification
     * @param $index integer. It is a control param for $data array
     * @return string. Return modify query
     * */
    public function mainModify($query, $i, $data, $modify, $index = 0)
    {
        $table = explode(" ", $query);
        if ((!isset($table[$i + 1])) or $table[$i + 1] == "ORDER") {
            if ($index < (count($data) - 1)) {
                if ((isset($table[$i + 1])) and $table[$i + 1] == "ORDER") $query = $this->slide($query, $i);
                $query = $this->place($query, $modify, $i, $data, $index);
                $query = $this->mainModify($query, $i + 1, $data, $modify, $index + 2);
            } else return $query;
        } else $query = $this->mainModify($query, $i + 1, $data, $modify, $index);
        return $query;
    }

    /**
     * This function slide ORDER BY if exists
     * @param $query string. It is a query
     * @param $i integer. It is a control param
     * @return string. Return slided query
     * */
    public function slide($query, $i)
    {
        $table = explode(" ", $query);
        $table[$i + 5] = $table[$i + 1];
        $table[$i + 6] = $table[$i + 2];
        $table[$i + 7] = $table[$i + 3];
        $table[$i + 8] = $table[$i + 4];
        return implode(" ", $table);
    }

    /**
     * Mission this function is a replace data to query
     * @param $query string. It is a query
     * @param $modify string. Data about form of modification
     * @param $i integer. It is a control param
     * @param $data array string. Additional data
     * @param $index integer. It is a control param for $data array
     * @return string. Return modify query
     * */
    public function place($query, $modify, $i, $data, $index)
    {
        $table = explode(" ", $query);
        if ($modify == "a") $table[$i + 1] = "AND";
        else if ($modify == "o") $table[$i + 1] = 'OR';
        else return $query;
        $table[$i + 2] = "`" . $data[$index] . "`";
        $table[$i + 3] = "=";
        $table[$i + 4] = "'" . $data[$index + 1] . "'";
        return implode(" ", $table);
    }

    /**
     * Function where create UPDATE query
     * @param $table string. Data about table
     * @param $data array string. Additional data (implicitly empty array)
     * @return string. Return query
     * */
    public function createInsertQuery($table, $data = [])
    {
        $query = "INSERT INTO `" . $table . "` ( ";
        $n = count($data);
        if ($n % 2 != 0) return $this->warning();
        $query = $this->columns($query, 0, $n, $data);
        $query .= ") VALUES (";
        $query = $this->values($query, ($n / 2), $n, $data);
        $query .= ");";
        return $query;
    }

    /**
     * Function which add data about columns to UPDATE query
     * @param $query string. It is a query
     * @param $i integer
     * @param $n integer
     * @param $data (table string) additional data (implicitly empty array)
     * @return string. Return query
     * */
    public function columns($query, $i, $n, $data = [])
    {
        for (; $i < ($n / 2); $i++) {
            $query .= "`" . $data[$i] . "`";
            if (($i) != (($n / 2) - 1)) {
                $query .= ", ";
            }
        }
        return $query;
    }

    /**
     * Function which add data about row to UPDATE query
     * @param $query string. It is a query
     * @param $i integer. It is a control param
     * @param $n integer. It is a size of array $data
     * @param $data (table string) additional data (implicitly empty array)
     * @return string. Return query
     * */
    public function values($query, $i, $n, $data = [])
    {
        for (; $i < $n; $i++) {
            $query .= "'" . $data[$i] . "'";
            if (($i) != ($n - 1)) {
                $query .= ", ";
            }
        }
        return $query;
    }

    /**
     * Function which informing about problem whit array
     * @return null
     * */
    public function warning()
    {
        echo 'Warning: Too small array in call method createQuery()';
        return NULL;
    }

    /**
     * Function which informing about problem whit key word WHERE
     * @return null
     * */
    public function warningWhere()
    {
        echo 'Warning: Key word WHERE not found. Please check called function in param 3 createQuery()';
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