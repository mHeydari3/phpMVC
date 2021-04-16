<?php
    // we will manage routes here
    Router::register('/' , 'indexController.index');
    Router::register('welcome' , 'indexController.saywelcome');
    Router::register('salam' , 'indexController.salam');
    Router::register('force' , "indexController.forceinput");
    Router::register('func/{name}/{?age}' , function ($name,$age=0){
        echo " $name you are $age";
    },['method'=>'GET']);