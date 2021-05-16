<?php namespace App;
use App\Router;
class Bootstrap {
    public function __construct(){
        Session::init();
    }
    public function run() {
        $URL = isset($_GET['url'])  && $_GET['url'] !== null ? strtolower($_GET['url']) : '/' ;
        Router::route ($URL);
    }
}
