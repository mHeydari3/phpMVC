<?php
namespace App;
class View{
    private static $_extenstion = '.php';
    public static function render($viewpath, $data){
            $viewpath = str_replace('.' , '\\' , $viewpath);
            $viewpath = $viewpath . VIEWEXTENTION;
            $loader = new \Twig_Loader_Filesystem(VIEWPATH);
            $twig   = new \Twig_Environment($loader);
            echo $twig->render($viewpath,$data);
    }
}