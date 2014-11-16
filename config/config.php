<?php

return new \Phalcon\Config(array(
     'database' => array(
        'adapter' => 'Mysql',
        'host' => array('127.0.0.1','127.0.0.2','127.0.0.3'),//第一个默认主库
        'username' => 'root',
        'password' => '',
        'dbname' => 'test',
        'prefix' => 't_',
        'charset' => 'utf8',
    ),
    'application' => array(
        'modulesDir' => APP_PATH . '/Modules/',
        'commonDir' => APP_PATH . '/Common/',
        'libraryDir' => APP_PATH . 'Llibraries/',
        'cacheDir' => APP_PATH . '/Cache/',
        'logsDir' => APP_PATH . '/_logs/',
        'baseUri' => '/',
        'debug' => true
    ),
    'namespaces' => [
        'Common' => APP_PATH . '/Common/',
        'Library' => APP_PATH . '/Libraries/',
        'Engine' => APP_PATH . '/Engines/',
        'Plugin' => APP_PATH . '/Plugins/',
    ],
    'modules' => [
        'Index',
        'Goods',
        'Demo',
    ],
    'views' => [
        'layouts' =>  '../../layouts/',
        'layout_body' => 'index',
        'errors' => APP_PATH . '/Views/errors',
        'templates' => APP_PATH . '/Views/templates/',
    ],

));
