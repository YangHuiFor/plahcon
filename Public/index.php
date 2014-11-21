<?php

/**
 * #====================================#
 * @todo 入口文件
 * @author functions
 * @date 2014-11-20 
 * #====================================#
 */
error_reporting(E_ALL);
define("APP_PATH", dirname(__DIR__));
define('APP_ENV', 'development');
require "Startup.php";
Startup::init()->startup();
