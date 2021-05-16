<?php
    // we will manage routes here
    App\Router::register('/' , 'userController.show');
    App\Router::register('all' , 'userController.showall');