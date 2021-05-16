<?php namespace App;
class Validator {
    private static $_errors ;
    private static $_errorstext ;


    public static function check($fields , $rules){
        self::$_errorstext = \App\Lang::get("validator");
        self::$_errors = [] ;
        foreach ($fields as $field => $value ) {
            $rule = $rules[$field] ;
            if (!($rule == '')) {
                $chk = self::_checkValid ($value , $rule , $field );
                if ($chk !== true) {
                    self::$_errors[$field] = $chk ;
                }
            }
        }


        return self::$_errors ;
    }

    private function _checkValid($value , $rules , $field) {
        $rules = explode ('|' , $rules );
        $class = get_class();
        foreach ($rules as $rule ){
            $ruleparts = explode(':' , $rule);
            $rulename = array_shift($ruleparts) ;
            if ($rulename == ''){
                return true;
            }
            $rulefunc = '_is' . ucfirst($rulename);
            array_unshift($ruleparts , $value);
            array_unshift($ruleparts , $field);
            $err = call_user_func_array([$class , $rulefunc] , $ruleparts);
            if ($err !== true) {
                return $err ;
            }
        }

        return true ;


    }


    private static function _getError ($funcname , $props) {
        array_unshift($props , self::$_errorstext[$funcname]);
        return call_user_func_array('sprintf' , $props) ;
    }

    private static function _isRequired($field , $value){
        $err = self::_getError("require" , [$field]);
        return ($value === null || trim($value) === '') ? $err : true;
    }

    private static function _isNumber ($field , $value){
        $err = self::_getError("number" , [$field]) ;
        return (!is_numeric($value)) ? $err : true;
    }

    private static function _isMax($field , $value , $max) {
        $err = self::_getError("max" , [$field , $max]) ;
        return (strlen($value) > $max ) ? $err : true;
    }






}
