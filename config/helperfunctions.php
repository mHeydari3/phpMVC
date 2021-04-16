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