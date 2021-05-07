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

function wrapValue($var , $wraperStart = '`' , $wraperEnd = null){
    if ($wraperEnd == null){
        $wraperEnd = $wraperStart;
    }

    if(is_array($var)){
        foreach ($var as $i=>$v){
            $var[$i] = $wraperStart . $var[$i] . $wraperEnd;
        }
        return $var;
    }else{
        return $wraperStart.$var.$wraperEnd;
    }
}

function strRepeatWrap($var , $count , $joinstr = ''){
    $arr = array_fill(0,$count , $var);
    return implode($joinstr , $arr);
}
