<?php

/**
 * #====================================#
 * @todo 应用配置
 * @author functions
 * @date 2014-11-20 
 * #====================================#
 */
return [
    'application' => [
        'modulesDir' => APP_PATH . '/Modules/',
        'commonDir' => APP_PATH . '/Common/',
        'libraryDir' => APP_PATH . 'Llibraries/',
        'cacheDir' => APP_PATH . '/Cache/',
        'logsDir' => APP_PATH . '/_logs/',
        'baseUri' => '/',
    ],
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
        'layouts' => '../../layouts/',
        'layout_body' => 'index',
        'errors' => APP_PATH . '/Views/errors',
        'templates' => APP_PATH . '/Views/templates/',
    ],
];
