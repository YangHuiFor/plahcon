<?php

/**
 * @todo 基础模块类
 * @author functions
 * @date 2014-11-9
 */

namespace Common;

use Phalcon\Loader,
    Phalcon\Mvc\ModuleDefinitionInterface;

class AbstractModule implements ModuleDefinitionInterface
{
    protected $ModuleName;
    protected $ModuleDir;

    /**
     * @todo 注册模块下的类，必须继承这个方法
     */
    public function registerAutoloaders()
    {
        /*$loader = new Loader();
        $loader->registerNamespaces(
            array(
                $this->ModuleName . '\Controllers' => $this->ModuleDir . '/controllers/',
                $this->ModuleName . '\Models' => $this->ModuleDir . '/models/',
            )
        );
        $loader->register();*/
    }

    /**
     * @todo 注册服务 ，必须继承这个方法
     */
    public function registerServices($di)
    {
        $di->get('dispatcher')->setDefaultNamespace($this->ModuleName . "\Controllers");
        $di->get('view')->setViewsDir($di->get('config')->views->templates . $this->ModuleName);
        $di->get('view')->setLayoutsDir($di->get('config')->views->layouts);
        $di->get('view')->setPartialsDir($di->get('config')->views->layouts);
    }
}


