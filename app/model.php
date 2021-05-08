<?php
namespace App;
class Model{

    private $_db;
    private $_isNew = true;
    protected $_fields = [];
    protected $_primaryKey = 'id';
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
        if ($this->_isNew !== true){
            $keys = array_keys($this->_fields);

            $qMarks = implode(', ' , wrapValue($keys , ':' , ' ')  );
            $variables = implode(', ' , wrapValue($keys)  ) ;
            $query = "INSERT INTO {$this->_tablename} ({$variables}) VALUES ({$qMarks})" ;
        }else {
            $keys = $this->_fields;
            $pk = $this->_primaryKey;
            $pkVal = $keys[$this->_primaryKey] ;
            unset($keys[$pk]) ;
            $variables = implode(', ' , wrapValue(array_keys($keys) , '`' , 'var' ) ) ;
            $query = "UPDATE {$this->_tablename} SET {$variables} WHERE `{$pk}`  = :{$pk} ";

        }

        $result = $this->db()->prepare($query);
        $result->execute($this->_fields);

        if ($this->dbError($result ) ) {
            throw new \Exception("Save into database Error!<pre>" . var_dump($result->errorInfo()) . "</pre>" , 1);
        }

        if($result){
            $this->_isNew = false;
        }
        return $result;
    }

    public function delete(){
        $pk = $this->_primaryKey;
        $query = "DELETE FROM {$this->_tablename} WHERE `{$pk}` = :{$pk}" ;
        return $this->db()->prepare($query)->execute([$pk=>$this->_fields[$pk]]);
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