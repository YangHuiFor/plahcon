<?php
 
/**
 * Bootstrap
 * @copyright Copyright (c) 2011 - 2012 Aleksandr Torosh (http://wezoom.com.ua)
 * @author Aleksandr Torosh <webtorua@gmail.com>
 */
use Phalcon\DI\FactoryDefault,
    Phalcon\Mvc\Application,
    Phalcon\Mvc\View,
    Phalcon\Mvc\Url as UrlResolver,
    Phalcon\Mvc\Router,
    Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
    Phalcon\Mvc\View\Engine\Php as PhpEngine,
    Application\Session\Adapter\Memcache as SessionAdapter;
 
class Bootstrap
{
 
    public static function run()
    {
        $debug = new Phalcon\Debug();
        $debug->listen();
 
        /**
         * =========================================================================
         * Конфигурация
         */
        $config = include __DIR__ . "/config/config.php";
 
        /**
         * =========================================================================
         * Application
         */
        $application = new Application();
 
        /**
         * =========================================================================
         * Dependency Injector
         */
        $di = new FactoryDefault();
 
        /**
         * =========================================================================
         * Подключение Модулей
         */
        $application->registerModules(array(
            'index'      => array(
                'className' => 'Index\Module',
                'path'      => __DIR__ . '/modules/Index/Module.php'
            ),
            'news'       => array(
                'className' => 'News\Module',
                'path'      => __DIR__ . '/modules/News/Module.php'
            ),
            'section'    => array(
                'className' => 'Section\Module',
                'path'      => __DIR__ . '/modules/Section/Module.php'
            ),
            'category'   => array(
                'className' => 'Category\Module',
                'path'      => __DIR__ . '/modules/Category/Module.php'
            ),
            'page'       => array(
                'className' => 'Page\Module',
                'path'      => __DIR__ . '/modules/Page/Module.php'
            ),
            'user-admin' => array(
                'className' => 'UserAdmin\Module',
                'path'      => __DIR__ . '/modules/UserAdmin/Module.php'
            ),
        ));
 
        /**
         * =========================================================================
         * Loader
         */
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces(array(
            //Подключаем библиотеки
            'Zend'        => __DIR__ . '/../vendor/zendframework/zendframework/library/Zend',
            'Application' => __DIR__ . '/modules/Application',
            'Image'       => __DIR__ . '/modules/Image',
            //Подключаем рабочие модули
            'Index'       => __DIR__ . '/modules/Index',
            'Api'         => __DIR__ . '/modules/Api',
            'News'        => __DIR__ . '/modules/News',
            'Section'     => __DIR__ . '/modules/Section',
            'Category'    => __DIR__ . '/modules/Category',
            'Page'        => __DIR__ . '/modules/Page',
            'UserAdmin'   => __DIR__ . '/modules/UserAdmin',
        ));
        $loader->register();
 
        $loader->registerDirs(
                array(
                    __DIR__ . "/plugins/"
                )
        )->register();
 
        /**
         * =========================================================================
         * Router
         */
        $router = new Router();
 
        $router->setDefaultModule('index');
        $router->setDefaultController('index');
        $router->setDefaultAction('index');
 
        //Дефолтный роутер
        $router->add('/:module/:controller/:action(/:params)?', array(
            'module'     => 1,
            'controller' => 2,
            'action'     => 3,
            'params'     => 5
        ))->setName('default');
 
        foreach ($application->getModules() as $module) {
            $className = str_replace('Module', 'Routes', $module['className']);
            if (class_exists($className)) {
                $class  = new $className();
                $router = $class->init($router);
            }
        }
 
        $di->set('router', $router);
 
        /**
         * =========================================================================
         * URL компонент
         */
        $di->set('url', function() {
                    $url = new UrlResolver();
                    $url->setBaseUri('/');
                    $url->setBasePath('/');
                    return $url;
                }, true);
 
 
        /**
         * =========================================================================
         * View, Layout
         */
        $view = new View();
 
        $view->setLayoutsDir('/../../../layouts/'); // директория с layout
        $view->setPartialsDir('../../../partials/'); // директория с partial
        $view->setLayout('main');
 
        //Регистрация движков вывода (rendering engines)
        $view->registerEngines(array(
            '.phtml' => function($view, $di) {
                $phtml = new PhpEngine($view, $di);
                return $phtml;
            },
        ));
        $di->set('view', $view);
 
        /**
         * =================================================================
         * DB
         */
        $di->set('db', function() use ($config) {
                    return new DbAdapter(array(
                        'host'     => $config->database->host,
                        'username' => $config->database->username,
                        'password' => $config->database->password,
                        'dbname'   => $config->database->name,
                        'charset'  => $config->database->charset,
                    ));
                });
 
        /**
         * =================================================================
         * Cache
         */
        $cache = new Phalcon\Cache\Backend\Memcache(new Phalcon\Cache\Frontend\Data(array(
            "lifetime" => 60,
            "prefix"   => 'avtopogliad',
                )), array(
            "host" => "localhost",
            "port" => "11211"
        ));
        $di->set('cache', $cache);
        $di->set('viewCache', $cache);
        $di->set('modelsCache', $cache);
 
        /**
         * =================================================================
         * modelsMetadata
         */
        if (APPLICATION_ENV == 'development') {
            $modelsMetadata = new Phalcon\Mvc\Model\Metadata\Memory();
        } else {
            /* $modelsMetadata = new Phalcon\Mvc\Model\MetaData\Apc(array(
              "lifetime" => 60,
              "prefix"   => "avtopogliad"
              )); */ // прийшлось тимчасово замінити -->
            $modelsMetadata = new Phalcon\Mvc\Model\Metadata\Memory();
        }
 
        $di->set('modelsMetadata', $modelsMetadata);
 
        /**
         * =========================================================================
         * Session
         */
        $di->set('session', function() {
                    $session = new SessionAdapter();
                    if (!isset($_SESSION)) {
                        session_start();
                    }
                    return $session;
                });
 
        /**
         * =================================================================
         * Flash
         */
        $di->set('flash', function() {
                    $flash = new \Phalcon\Flash\Session(array(
                        'error'   => 'alert alert-error',
                        'success' => 'alert alert-success',
                        'notice'  => 'alert alert-info',
                    ));
                    return $flash;
                });
 
        /**
         * =================================================================
         * Dispatcher, Events
         */
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
 
        $eventsManager = new \Phalcon\Events\Manager();
        $eventsManager->attach("dispatch", function($event, $dispatcher, $exception) use ($di) {
 
                    /**
                     * =====================================================
                     * Localization
                     */
                    if ($event->getType() == 'beforeDispatchLoop') {
                        $request   = $di->get('request');
                        $queryLang = $request->getQuery('lang');
                        if (!$queryLang) {
                            $lang = $dispatcher->getParam('lang');
                        } else {
                            $lang = $queryLang;
                        }
 
                        if ($lang == 'ru') {
                            define('LANG', 'ru');
                            define('LANG_SUFFIX', '_ru');
                            define('LANG_URL', '/ru');
                            define('LOCALE', 'ru_RU');
                        } else {
                            define('LANG', 'uk');
                            define('LANG_SUFFIX', '');
                            define('LANG_URL', '');
                            define('LOCALE', 'uk_UA');
                        }
                        Locale::setDefault(LOCALE);
 
                        $di->set('translate', new \Phalcon\Translate\Adapter\NativeArray(array("content" => include __DIR__ . '/languages/' . LANG . '.php')));
                    }
 
                    /**
                     * =====================================================
                     * Errors. Обработка ошибок
                     */
                    if ($event->getType() == 'beforeNotFoundAction') {
                        $dispatcher->forward(array(
                            'module'     => 'index',
                            'controller' => 'error',
                            'action'     => 'error'
                        ));
                        return false;
                    }
 
                    //Альтернативный путь. Когда контроллер или екшн не найдены
                    if ($event->getType() == 'beforeException') {
                        switch ($exception->getCode()) {
                            case \Phalcon\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                            case \Phalcon\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                                $dispatcher->forward(array(
                                    'module'     => 'index',
                                    'controller' => 'error',
                                    'action'     => 'error'
                                ));
                                return false;
                        }
                    }
 
                    /**
                     * =====================================================
                     * ACL
                     * Плагин Security
                     */
                    if ($event->getType() == 'beforeExecuteRoute') {
                        $eventsManager = $di->getShared('eventsManager');
                        $security      = new Security($di);
                        $security->beforeExecuteRoute($dispatcher);
                        $eventsManager->attach('security', $security);
                    }
                });
 
        //Bind the EventsManager to the dispatcher
        $dispatcher->setEventsManager($eventsManager);
 
        $di->setShared('dispatcher', $dispatcher);
 
        $di->set('helper', new \Application\Mvc\Helper());
 
        $application->setDI($di);
 
        /**
         * =================================================================
         * Widget. Инициализация абстрактного класса.
         */
        \Application\Widget\Proxy::setDi($di);
 
        /**
         * =================================================================
         * Отдача в браузер
         */
        echo $application->handle()->getContent();
 
    }
 
}