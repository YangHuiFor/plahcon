<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'test',
    ),
    'application' => array(
        'modulesDir'      => APP_PATH . '/modules/',
        'commonDir'      => APP_PATH . '/common/',
        'viewsDir'       => APP_PATH . '/views/templates/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => APP_PATH . '/cache/',
        'baseUri'        => '/',
    ),
    'namespaces' => [
        'Common' => APP_PATH . '/common/',
        'Library' => APP_PATH . '/library/',
    ],
    'modules' => [
        'Index',
        'Goods',
    ],
    'views' => [
        'layout' => APP_PATH . '/views/layout',
    ],

));
