<?php
error_reporting(E_ALL);
define("APP_PATH", dirname(__DIR__));
require "PLaunch.php";

PLaunch::init()->register()->startup();