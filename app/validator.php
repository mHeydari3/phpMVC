<?php namespace App;
class Validator {
    private static $_errors ;


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


}
