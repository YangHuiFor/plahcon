<?php

return new \Phalcon\Config(array(
    // 'database' => array(
    //     'adapter' => 'Mysql',
    //     'host' => '192.168.1.33',
    //     'username' => 'admin',
    //     'password' => 'Admin_12345',
    //     'dbname' => 'test',
    // ),
     'database' => array(
        'adapter' => 'Mysql',
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'dbname' => 'test',
    ),
    'application' => array(
        'modulesDir' => APP_PATH . '/modules/',
        'commonDir' => APP_PATH . '/common/',
        'libraryDir' => APP_PATH . '/library/',
        'cacheDir' => APP_PATH . '/cache/',
        'baseUri' => '/',
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
        'layouts' =>  '../../layouts/',
        'layout_body' => 'index',
        'error' => APP_PATH . '/views/error',
        'templates' => APP_PATH . '/views/templates/',
    ],

));
