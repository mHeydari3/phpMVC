<?php
require_once '../vendor/autoload.php';
require_once '../app/bootstrap.php' ;
require_once '../config/config.php';
require_once '../config/helperfunctions.php';
require_once '../app/router.php';
require_once '../config/route.php';
$app = new App\Bootstrap();
$app->run();
//$URL = isset($_GET['url']) && $_GET['url'] != null ? strtolower($_GET['url']) : '/';
//
//Router::route($URL);


