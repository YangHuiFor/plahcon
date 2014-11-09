<?php

/**
 * @todo 框架准备配置文件
 * @author functions
 * @date 2014-11-9 
 */
if (!defined('APP_PATH')) {
    throw new Exception('APP_PATH常量未定义！');
}

use Phalcon\Loader;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Mvc\Application;

class PLaunch
{
	protected $config;
	const APP_CONFIG_PATH = "/config/";
	private $application;

	public function __construct()
	{
		$this->config = $this->getConfig();
	}

	public static function init() {
		return new self;
	}
	/**
	 * @todo 获取配置
	 */
	public function getConfig()
	{	static $config;
		if (is_null($config)) {
            $config = include APP_PATH . self::APP_CONFIG_PATH . '/config.php';
        }
        return $config;
	}

	/**
	 * @todo 注册加载
	 */
	public function registerNamespaces()
	{
		if($this->config->namespaces) {
			$loader = new Loader();
			$modulesClass = $this->getRegisterModulesClass();
			$otherClass = (array)$this->config->namespaces;
			$class = array_merge($modulesClass,$otherClass);
			$loader->registerNamespaces($otherClass)->register();
		}
	}

	/**
	 * @todo 注册路由
	 */
	public function registerRouter(FactoryDefault $di)
	{
		$di->set('router', function () {
		    $router = new Router();
		    $router->add("/:module/:controller/:action", array(
		        'module'     => 1,
		        'controller' => 2,
		        'action'     => 3,
		    ));
		    $router->add("[/]", array(
		        'module'     => 'Index',
		        'controller' => 'Index',
		        'action'     => 'index',
		    ));
		    return $router;
		});
	}


	public function registerUrl(FactoryDefault $di)
	{	
		$config = $this->config;
		$di->set('url', function () use ($config) {
		    $url = new UrlResolver();
		    $url->setBaseUri($config->application->baseUri);

		    return $url;
		}, true);
	}

	public function registerView(FactoryDefault $di)
	{	
		$config = $this->config;
		$di->set('view', function () use ($config) {
	    $view = new View();
	    // $view->setLayoutsDir('../views/layouts/');
	    // $view->setLayoutsDir($config->views->layout);
     //    $view->setLayout('index');
	    $view->registerEngines(array(
		        '.volt' => function ($view, $di) use ($config) {
		            $volt = new VoltEngine($view, $di);
		            $volt->setOptions(array(
		                'compiledPath' => $config->application->cacheDir,
		                'compiledSeparator' => '_'
		            ));
		            return $volt;
		        },
		        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
		    ));
		    return $view;
		}, true);
	}


	public function registerDB(FactoryDefault $di)
	{
		$config = $this->config;
		$di->set('db', function () use ($config) {
		    return new DbAdapter(array(
		        'host' => $config->database->host,
		        'username' => $config->database->username,
		        'password' => $config->database->password,
		        'dbname' => $config->database->dbname
		    ));
		});
	}

	public function registerMeta(FactoryDefault $di)
	{$config = $this->config;
		$di->set('modelsMetadata', function () {
		    return new MetaDataAdapter();
		});
	}

	public function registerSession(FactoryDefault $di)
	{
		$di->set('session', function () {
		    $session = new SessionAdapter();
		    $session->start();

		    return $session;
		});
	}

	protected function registerModules()
	{	
		if($this->application) {
			$this->application->registerModules($this->getRegisterModules());
		}
	}

	/**
	 * @todo 获取注册模块
	 */
	protected function getRegisterModules()
	{
		if($this->config->modules) {
			$modules = [];
			foreach ($this->config->modules as $module) {
				$modules[strtolower($module)] = [
					'className' => $module . '\Module',
					'path'      =>  $this->config->application->modulesDir. $module. '/Module.php',
				];
			}
			return $modules;
		}
	}

	protected function getRegisterModulesClass()
	{
		if($this->config->modules) {
			$modulesClass = [];
			foreach ($this->config->modules as $module) {
				$modulesClass[$module . '\Controllers'] = $this->config->application->modulesDir. $module.  '/controllers/';
				$modulesClass[$module . '\Models'] = $this->config->application->modulesDir. $module.  '/models/';
			}
			return $modulesClass;
		}
	}

	public function register()
	{
		$di = new FactoryDefault();
		$this->registerNamespaces();
		$this->registerRouter($di);
		$this->registerUrl($di);
		$this->registerView($di);
		$this->registerDB($di);
		$this->registerMeta($di);
		$this->registerSession($di);
		$this->application =  new Application($di);
		$this->registerModules();
		return $this;
	}

	public function startup()
	{
		echo $this->application->handle()->getContent();
		return $this;
	}
}
