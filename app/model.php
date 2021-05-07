<?php
namespace App;
class Model{

    private $_db;
    protected $_fields = [];
    protected $_tablename = null;
    function __construct(){
        if ($this->_tablename === null){
            $this->_tablename = Env::get('database')['table_perfix'] . strtolower(ltrim(get_class($this) , 'App\\'));

        }

        $this->_initDB();

    }
    private function _initDB(){
        try {
            $dbconf = Env::get('database');
            $connectionString = $dbconf['driver'] . ': host=' . $dbconf['host'] . '; dbname=' . $dbconf['dbname'] . '; charset=' . $dbconf['charset'] ;
            $this->_db = new Db($connectionString , $dbconf['username'] , $dbconf['password']);
        }
        catch (\PDOException $e){
            dd ($e->getMessage());
        }
    }

    public function save(){
        $qMarks = implode(', ' , wrapValue(array_keys($this->_fields) , ':' , ' ')  );
        $variables = implode(', ' , wrapValue(array_keys($this->_fields))  ) ;
        $query = "INSERT INTO {$this->_tablename} ({$variables}) VALUES ({$qMarks})" ;

        $result = $this->db()->prepare($query);
        $result->execute($this->_fields);

        if ($this->dbError($result ) ) {
            throw new \Exception("Save into database Error!<pre>" . var_dump($result->errorInfo()) . "</pre>" , 1);
        }
    }

    protected function db(){
        return $this->_db;
    }


    public function dbError($result ){
        return $result->errorCode() === '00000' ? false : $this->db()->errorCode();
    }

    public function __set($var , $val){
        if (in_array($var , array_keys($this->_fields) ) ){
            $this->_fields[$var] = $val;
        }
    }
}