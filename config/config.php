<?php
    define('ROOTPATH' , dirname(dirname(__FILE__)) . '\\');
    define('DIRSEP' , DIRECTORY_SEPARATOR);
    define('VIEWPATH' , ROOTPATH . 'views' . DIRSEP);
    define('VIEWEXTENTION' , '.twig');
    define('MASTERPAGE' , VIEWPATH.'masterpage'.VIEWEXTENTION);
    define('LANGPATH', dirname(__FILE__) . DIRSEP . 'lang' . DIRSEP) ;
    define('LANGDEFAULT' , 'en') ;