<?php
namespace App;
class View{
    private static $_extenstion = '.php';
    public static function render($viewpath, $data){
            $viewpath = str_replace('.' , '\\' , $viewpath);
            $path =  VIEWPATH . $viewpath . self::$_extenstion;
            if (is_readable($path)){
                include_once($path);
            }else{
                throw new \Exception("view $path is not accessible.");
            }
    }
}