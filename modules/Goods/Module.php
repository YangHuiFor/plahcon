<?php

namespace Goods;

use Common\AbstractModule;

use Phalcon\Loader,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\View,
    Phalcon\Mvc\ModuleDefinitionInterface;
class Module extends AbstractModule
{

    public function __construct()
    {
        $this->ModuleName = __NAMESPACE__;
        $this->ModuleDir = __DIR__;
    }


    public function registerServices($di)
    {	

    	 //Registering a dispatcher
        $di->set('dispatcher', function() {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace($this->ModuleName . "\Controllers");
            return $dispatcher;
        });

    	$di->get('view')->setViewsDir( '../views/templates/' . $this->ModuleName);
        $di->get('view')->setLayoutsDir( 'layout/' );
        $di->get('view')->setTemplateAfter( 'layout') ;
    }

}