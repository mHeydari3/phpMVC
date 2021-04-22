<?php
function dd ($arg){
    echo '<pre>';print_r($arg);die();
}
function d($arg){
    echo '<pre>'; print_r($arg);
}
function clearArray(&$arr , $key=""){
    $ret = [];
    foreach($arr as $index=>$value){
        if($value !== $key)
            $ret[$index] = $value;
    }
    $arr = $ret;
}

function autoload($classname){
    $path = ROOTPATH.strtolower(str_replace('/' , '\\' , $classname)) . '.php';
    if (is_readable($path)){
        require_once $path;
    }else{
        throw new Exception ("Error file path {{$path}}", 1);

    }
}
spl_autoload_register('autoload');