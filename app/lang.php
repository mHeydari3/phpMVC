<?php namespace App;
class Lang{
    public static function get($path) {
        $path = explode('.' , $path) ;
        $lang = 'en' ;
        $langfilepath = LANGPATH . $lang . '.json' ;
        if (!is_readable($langfilepath)) {
            $langfilepath = LANGPATH.LANGDEFAULT.'.json';
        }
        $lang = json_decode(file_get_contents($langfilepath) , true) ;
        if (count ($path) == 1 ) {
            return $lang[$path[0]] ;
        }
        return $lang[$path[0]][$path[1]] ;
    }
}
