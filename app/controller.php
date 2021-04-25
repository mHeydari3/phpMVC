<?php
namespace App;
class Controller{
    function __construct(){
        echo "sakhteh shod.";
    }
    protected function render($viewpath , $data = []){
        View::render($viewpath , $data);
    }
}