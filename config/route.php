<?php
    // we will manage routes here
    Router::register('/' , 'userController.show');
    Router::register('all' , 'userController.showall');