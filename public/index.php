<?php
require_once '../config/helperfunctions.php';
require_once '../app/router.php';
require_once '../config/route.php';
$URL = isset($_GET['url']) && $_GET['url'] != null ? strtolower($_GET['url']) : '/';

Router::route($URL);


