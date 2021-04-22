<?php
class Router{

    private static $_ROUTES = array(),

                   $_DEFAULT_CONFIG=[
                       'method'=>'GET'
    ];


    public static function route($url){
       $checkedRoute = self::checkRoute($url);
       if (is_callable($checkedRoute['action'])){
           call_user_func_array($checkedRoute['action'] , $checkedRoute['params']);
       }
       else if ($checkedRoute !== false){
           $urlParts = explode ('.' , $checkedRoute['action']);

           $controllerName = str_replace('Controller','',$urlParts[0]);

           $actionName = (isset($urlParts[1]) ? $urlParts[1] : 'index').'Action';

           $params = $checkedRoute['params'];

           $controllerClassName = ucfirst($controllerName);

           $controllerClassName = 'App\\Controllers\\'.$controllerClassName;

           $controllerObject = new $controllerClassName;

           $controllerClassName = ucfirst($controllerName);

           if (method_exists($controllerObject , $actionName)){
               call_user_func_array(array($controllerObject, $actionName), $params);
           }else {
               echo "error: action " . $actionName . "does not exists!";
           }


       }else {
           echo "404! Page not found..!";
       }




    }
    private static function checkRoute($url){
        foreach (self::$_ROUTES as $conf){
            $name = $conf['name'];
            $filterdParams = self::removeArbitraryParams($conf['params']);
            $urlName = rtrim(substr($url , 0 , strlen($name.'/')   )  ,  '/');
            if ($name === ($urlName !== '' ? $urlName:'/')){
                if ($_SERVER['REQUEST_METHOD'] == $conf['method']){
                    $urlParts = explode ('/' , trim(substr($url,strlen($name)) , '/'));
                    clearArray($urlParts);
                    if ($name == '/' || count($conf['params'])  >= count($urlParts)   ){
                        foreach($urlParts as $index=>$value){
                            if ($urlParts[$index])
                                $filterdParams[$index] = $urlParts[$index];
                        }
                        $conf['params'] = $filterdParams;
                        return $conf;
                    }
                }
            }
        }
        return false;
    }

    private static function removeArbitraryParams($params){
        $params2 = [];
        foreach ($params as $key=>$value){
            if($value[0] === "?"){
                return $params2;
            }
            $params2[] = $value;

        }
        return [];
    }
    private static function getConfigs($config){
        $ret = self::$_DEFAULT_CONFIG;
        foreach ($config as $cName => $cVal){
            $ret [$cName] = $cVal;

        }
        return $ret;
    }
    private static function defaultRoute($url){
        $url = explode('/' , $url);
        $controllerName = $url[0];
        $actionName = (isset($url[1]) ? $url[1] : 'index').'Action';
        $params = (count($url) > 2 )? array_slice($url,2-count($url)) : array();

        if (file_exists("../controllers/{$controllerName}.php")){
            require_once "../controllers/{$controllerName}.php";
            $controllerName = ucfirst($controllerName);
            $controllerObject= new $controllerName ;

            //$controllerObject->$actionName();
            if (method_exists($controllerObject ,$actionName )){
                call_user_func_array( array($controllerObject,$actionName),$params );

            }else{
                echo "error: action $actionName , does not exist";
            }
        }else {
            echo "error: controller $controllerName , does not exist";
        }
    }

    public static function register ($route,$routeAction , $config=[]) {
        $config = self::getConfigs($config);
        preg_match_all('/^([^{]+)\//' , $route , $matches);
        $rParams = [];
        $rName = isset($matches[1][0]) ? $matches[1][0]:$route;
        if ($rName !== $route){
            preg_match_all('/\/{([^}]+)}/U' , $route , $matches);
            $rParams = $matches[1];

        }
        $config['action'] = $routeAction;
        $config['params'] = $rParams ;
        $config['name']   = $rName;
        self::$_ROUTES[]  = $config;

    }


}