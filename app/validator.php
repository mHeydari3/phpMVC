<?php namespace App;
class Validator {
    private static $_errors ;



    public static function check($fields , $rules){
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


    private static function _isRequired($field , $value){
        $err = sprintf("%s is required" , $field) ;
        return ($value === null || trim($value) === '') ? $err : true;
    }

    private static function _isNumber ($field , $value){
        $err = sprintf("%s is not a number" , $field) ;
        return (!is_numeric($value)) ? $err : true;
    }

    private static function _isMax($field , $value , $max) {
        $err = sprintf("%s length must be less than %d" , $field , $max) ;
        return (strlen($value) > $max ) ? $err : true;
    }






}
