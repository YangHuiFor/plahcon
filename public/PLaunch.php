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
use Phalcon\Mvc\Dispatcher;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Mvc\Application;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as FileLogger;
use Plugin\NotFoundPlugin;
class PLaunch
{
    protected $config;
    const APP_CONFIG_PATH = "/config/";
    private $application;

    public function __construct()
    {
    }

    public static function init()
    {
        return new self;
    }

    /**
     * @todo 获取配置
     */
    public function registerConfig(FactoryDefault $di)
    {
        static $config;
        if (is_null($config)) {
            $config = include APP_PATH . self::APP_CONFIG_PATH . '/config.php';
        }
        $di->set('config', $config,true);
        $this->config = $config;
    }


    /**
     * @todo 注册加载
     */
    public function registerNamespaces()
    {
        if ($this->config->namespaces) {
            $loader = new Loader();
            $otherClass = (array)$this->config->namespaces->toArray();
            $moduleClass = $this->getRegisterModulesClass();
            $class = array_merge($otherClass, $moduleClass);
            $loader->registerNamespaces($class)->register();
        }
    }

    public function registerDispatcher(FactoryDefault $di)
    {
        $config = $this->config;
        $di->set('dispatcher', function () use ($config) {
            $eventsManager = new EventsManager;
            $eventsManager->attach('dispatch:beforeException', new Plugin\NotFoundPlugin);
            $dispatcher = new Dispatcher;
            $dispatcher->setEventsManager($eventsManager);
            return $dispatcher;
        }, true);
    }

    /**
     * @todo 注册路由
     */
    public function registerRouter(FactoryDefault $di)
    {
        $di->set('router', function () {
            $router = new Router();

            $router->setDefaultModule('index');
            $router->setDefaultController('index');
            $router->setDefaultAction('index');

            $router->add("/:module/:controller/:action", array(
                'module' => 1,
                'controller' => 2,
                'action' => 3,
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
            $view->registerEngines(array(
                '.phtml' => function ($view, $di) {
                    $phtml = new PhpEngine($view, $di);
                    return $phtml;
                },
            ));
            return $view;
        }, true);
    }



    public function registerMeta(FactoryDefault $di)
    {
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
        if ($this->application) {
            $this->application->registerModules($this->getRegisterModules());
        }
    }

    /**
     * @todo 获取注册模块
     */
    protected function getRegisterModules()
    {
        if ($this->config->modules) {
            $modules = [];
            foreach ($this->config->modules as $module) {
                $modules[strtolower($module)] = [
                    'className' => $module . '\Module',
                    'path' => $this->config->application->modulesDir . $module . '/Module.php',
                ];
            }
            return $modules;
        }
    }

    protected function getRegisterModulesClass()
    {
        if ($this->config->modules) {
            $modulesClass = [];
            foreach ($this->config->modules as $module) {
                $modulesClass[$module . '\Controllers'] = $this->config->application->modulesDir . $module . '/controllers/';
                $modulesClass[$module . '\Models'] = $this->config->application->modulesDir . $module . '/models/';
            }
            return $modulesClass;
        }
    }

    public function register()
    {	
    	$debug = new \Phalcon\Debug();
        $debug->listen();
        $di = new FactoryDefault();
        $this->registerConfig($di);
        $this->registerNamespaces();
        $this->registerRouter($di);
        $this->registerDispatcher($di);
        $this->registerUrl($di);
        $this->registerView($di);
        $this->registerMeta($di);
        $this->registerSession($di);
        $di->set('modelsManager', function() {
            return new Phalcon\Mvc\Model\Manager();
         });
        $this->application = new Application($di);
        $this->registerModules();

        return $this;
    }

    public function startup()
    {
        echo $this->application->handle()->getContent();
        return $this;
    }
}
