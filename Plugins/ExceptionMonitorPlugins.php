<?php

namespace Plugin;

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatcherException;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

/**
 * ExceptionMonitorPlugins
 */
class ExceptionMonitorPlugins extends Plugin
{

    /**
     * This action is executed before execute any action in the application
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     */
    public function beforeException(Event $event, MvcDispatcher $dispatcher, $exception)
    {
        if ($exception instanceof DispatcherException) {
            switch ($exception->getCode()) {
                case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                    $dispatcher->forward(array(
                        'namespace' => 'Demo\Controllers',
                        'controller' => 'errors',
                        'action' => 'show404'
                    ));
                    return false;
            }
        }
        $dispatcher->forward(array(
            'namespace' => 'Demo\Controllers',
            'controller' => 'errors',
            'action' => 'show500'
        ));
        return false;
    }

    public function beforeExecuteRoute(Event $event, MvcDispatcher $dispatcher, $exception)
    {
        var_dump($exception);
        die;
        return false;
    }

    public function beforeDispatch(Event $event, MvcDispatcher $dispatcher, $exception)
    {
        var_dump($exception);
        die;
        return false;
    }

    public function  afterDispatchLoop(Event $event, MvcDispatcher $dispatcher, $exception)
    {
        var_dump($exception);
        die;
        return false;
    }
}
