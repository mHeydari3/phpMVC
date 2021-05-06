<?php
namespace App;
class Model{

    private $_db;

    function __construct(){
        try {
            $dbconf = Env::get('database');
            $connectionString = $dbconf['driver'] . ': host=' . $dbconf['host'] . '; dbname=' . $dbconf['dbname'] . '; charset=' . $dbconf['charset'] ;
            $this->db = new Db($connectionString , $dbconf['username'] , $dbconf['password']);
        }
        catch (\PDOException $e){
            dd ($e->getMessage());
        }

    }
    protected function db(){
        return $this->_db;
    }

}