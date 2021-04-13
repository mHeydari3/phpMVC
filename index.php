<?php
if ($_GET){
    if (isset($_GET['pages']) && $_GET['pages']!=''){

        $p  = $_GET['pages'];
        $PAGE_URL =  'pages/'.$p . '.php';
        if (file_exists($PAGE_URL)){
            require_once $PAGE_URL;
        }else{
            echo "NOT FOUND";
        }
    }else{
        require_once 'pages/page1.php';
    }
}