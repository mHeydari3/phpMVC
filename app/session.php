<?php namespace App;
class Session {
    private static $_id;
    public static function init(){
        if(session_id() === null ){
            session_start();
            self::$_id = session_id() ;
        }
    }
    public static function set($var , $val) {
        $_SESSION[$var] = $val;
    }
    public static function get($var , $default=null){
        return isset($_SESSION[$var]) ? $_SESSION[$var] : $default;
    }
    public static function clear(){
        session_destroy(self::$_id) ;
    }
}
