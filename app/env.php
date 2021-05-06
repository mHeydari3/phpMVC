<?php namespace App;
class Env{
    private static $_conf = null;

    public static function get($path){
        self::$_conf = self::$_conf ? self::$_conf : json_decode(file_get_contents(ROOTPATH . 'env') , true);
        if(isset(self::$_conf[$path])){
            return self::$_conf[$path];
        }
        throw new \Exception("Environment $path does not exist" , 1);


    }
}
