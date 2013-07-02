<?php

class Database {

    private $databaseName = 'image';
    private $host = 'localhost';
    private $user = 'test';
    private $password = 'test';
    private static $instance;
    private $last_sql;
    private $d_b;
    private $connection;

    private function __construct() {
        $this->connection = mysql_connect($this->host, $this->user, $this->password) or die(mysql_error());
        $this->d_b = mysql_select_db($this->databaseName, $this->connection) or die(mysql_error());
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function query($query) {
        $this->last_sql = mysql_query($query) or die(mysql_error());
        return $this;
    }

    public function getLastId($tablename){
        $row = $this->query(" SELECT max(id) as id FROM {$tablename} ")->result();
        if(isset($row[0]['id'])){
            return $row[0]['id'];
        }
        return false;
    }

    public function result(){
        if (!is_resource($this->last_sql)) {
            return null;
        }
        if ($this->last_sql) {
            $result = array();
            while ($row = mysql_fetch_assoc($this->last_sql)) {
                   $result[] = $row;
            }
            return $result;
        }
    }

    public function insert($tablename, $data) {
        $fields = '';
        $values = '';
        foreach ($data as $field => $value) {
            if ($fields)
                $fields.=',';
            if ($values)
                $values.=',';
            $fields.="`" . mysql_escape_string($field) . "`";
            $values.="'" . mysql_escape_string($value) . "'";
        }
        $query = "INSERT INTO " . $tablename . " (" . $fields . ") VALUES (" . $values . ")";

        return $this->query($query);
    }

    public function delete($tablename, $id) {
        $query = "DELETE FROM {$tablename} WHERE `id`= {$id}";
        return $this->query($query);
    }

    public function get_where($tablename, $where, $limit = null,$order_by = '', $offset = 0) {
        $string = '';
        $query = "SELECT * FROM {$tablename}  {$where}";
        if (is_integer($limit))
            $query.=" {$order_by} LIMIT {$offset},{$limit} ";
        return $this->query($query);
    }

}

?>