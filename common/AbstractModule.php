<?php

/**
 * @todo 基础模块类
 * @author functions 
 * @date 2014-11-9 
 */

namespace Common;

use Phalcon\Loader,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\View,
    Phalcon\Mvc\ModuleDefinitionInterface;

class AbstractModule implements ModuleDefinitionInterface
{
	protected $ModuleName;
	protected $ModuleDir;

	public function __construct()
	{
		
	}

	/**
	 * @todo 注册模块下的类
	 */
	public function registerAutoloaders()
    {	
    	$loader = new Loader();
        $loader->registerNamespaces(
            array(
                $this->ModuleName . '\Controllers' => $this->ModuleDir . '/controllers/',
                $this->ModuleName . '\Models'      => $this->ModuleDir . '/models/',
            )
        );
        $loader->register();
    }

    public function registerServices($di)
    {
        //Registering a dispatcher
        // $di->set('dispatcher', function() {
        //     $dispatcher = new Dispatcher();
        //     $dispatcher->setDefaultNamespace( $this->ModuleName . "\Controllers");
        //     return $dispatcher;
        // });
        $di->get('dispatcher')->setDefaultNamespace($this->ModuleName . "\Controllers");
        $di->get('view')->setViewsDir( '../views/templates/' . $this->ModuleName);
        $di->get('view')->setLayoutsDir( '../../layouts/' );
        $di->get('view')->setTemplateAfter( 'index') ;
    }
}


