<?php
namespace App;
class Model{

    private $_db;
    private $_class ;
    private $_readables = [] ;
    private $_editables = [] ;
    private $_rules = [] ;
    private $_fields = [];
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

    public function _convertRowToObject($res){
        $objs = [];
        foreach ($res as $index => $row) {
            $className = get_class($this);

            $obj = new $className ();

            $fields = array_keys($obj->getFields());
            foreach ($fields as $fieldName){
                $obj->$fieldName = $row[$fieldName];
            }
            $objs[] = $obj;
        }
        return $objs;
    }
    public function findBy($val , $prop) {
        $qMarks = implode (', '    ,   wrapValue(array_keys($this->_fields)  , ':' , ''   )   ) ;
        $variables = implode(', ' , wrapValue(array_keys($this->_fields) )  );
        $query = "SELECT * FROM {$this->_tablename} WHERE `{$prop}` = :{$prop} " ;
        $h = $this->db()->prepare($query);
        $h->execute([$prop => $val]);
        return $this->_convertRowToObject($h->fetchAll () ) ;
    }

    public function select($conds){
        $variables = [];
        foreach($conds as $prop=>$conf){
            $conf = is_array($conf ) ? $conf : [$conf];
            $comb = ' ' . (isset($conf[2]) ? strtoupper($conf[2]) : 'AND') . ' ';
            $op   = isset($conf[1]) ? $conf[1] : '=' ;
            $variables[] = $comb . wrapValue($prop) . $op . ':' . $prop ;
            $conds[$prop] = $conf[0];
        }
        $variables = ltrim(ltrim( implode(' ' , $variables)   , ' AND') , ' OR');
        $query     = "SELECT * FROM {$this->_tablename} WHERE {$variables}" ;
        $h = $this->db()->prepare($query);

        $h->execute($conds);
        return $this->_convertRowToObject($h->fetchAll () ) ;
    }

    public function save(){

        if ($this->_isNew() !== true){
            $keys = $this->_fields;
            $pk = $this->_primaryKey;
            $pkVal = $keys[$this->_primaryKey] ;
            unset($keys[$pk]) ;
            $variables = implode(', ' , wrapValue(array_keys($keys) , '`' , 'var' ) ) ;
            $query = "UPDATE {$this->_tablename} SET {$variables} WHERE `{$pk}`  = :{$pk} ";
        }else {
            $keys = array_keys($this->_fields);

            $qMarks = implode(', ' , wrapValue($keys , ':' , ' ')  );
            $variables = implode(', ' , wrapValue($keys)  ) ;
            $query = "INSERT INTO {$this->_tablename} ({$variables}) VALUES ({$qMarks})" ;


        }

        $result = $this->db()->prepare($query);
        $result->execute($this->_fields);

        if ($this->dbError($result ) ) {
            throw new \Exception("Save into database Error!<pre>" . var_dump($result->errorInfo()) . "</pre>" , 1);
        }
        return $result;
    }

    public function delete(){
        $pk = $this->_primaryKey;
        $query = "DELETE FROM {$this->_tablename} WHERE `{$pk}` = :{$pk}" ;
        return $this->db()->prepare($query)->execute([$pk=>$this->_fields[$pk]]);
    }

    public static function table($tablename){
        $_class = '\\App\\Models\\' . ucfirst($tablename);
        return new $_class;
    }

    protected function db(){
        return $this->_db;
    }


    public function dbError($result ){
        return $result->errorCode() === '00000' ? false : $this->db()->errorCode();
    }

    public function __set($var , $val){
        if (in_array($var , array_keys($this->_fields))  && $this->_editables[$var] === true     ){
            return $this->_fields[$var] = $val;
        }
        throw new \Exception("Property $var is not editable"  , 1) ;
    }


    public function __get($var){
        if (in_array($var , array_keys($this->_fields))  && $this->_readables[$var] === true ) {
            return $this->_fields[$var];
        }
        throw new \Exception ("property $var is not readable" , 1) ;
    }

    private function _isNew(){
        return ($this->_fields[$this->_primaryKey] === null) ? true : false;
    }

    protected function setInitialFields($props) {
        foreach($props as $key => $conf) {
            if(is_int($key)){
                $key = $conf;
                $conf = [] ;
            }

            $this->_readables[$key] = isset($conf['readable']) ? $conf['readable'] : true ;
            $this->_editables[$key] = isset($conf['editable']) ? $conf['editable'] : true ;
            $this->_rules[$key]     = isset($conf['rule'])     ? $conf['rule']     : '';
            $this->_fields[$key]    = isset($conf['default'])  ? $conf['rule']     : null ;

        }
    }

    public function validate() {
        $errors = Validator::check($this->_fields , $this->_rules) ;
        return (count($errors) === 0) ? true : $errors;
    }




    public function __call($func , $params){
        $funcname = $func;
        if (substr($funcname , 0 , strlen('findBy')) === 'findBy') {
            $prop = strtolower( ltrim($funcname , 'findBy') ) ;
            if ( in_array($prop , array_keys($this->_fields) ) ) {
                $params[] = $prop ;

                return call_user_func_array(array($this,'findBy'),  $params);
            }
        }
        else if (substr($funcname , 0 , strlen('find'))  === 'find' ) {
            foreach ($params[0] as $prop => $value) {
                if (!in_array($prop , array_keys($this->_fields))){
                    throw new \Exception("Property {{$prop}} does not supported by {{__CLASS__}}");
                }
            }

            return call_user_func_array(array($this,'select'),$params);


        }





    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->_fields;
    }


}