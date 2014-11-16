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


        /**
         * @todo 覆盖上一级，重置
         */
   /**public function registerServices($di)
   {
       $di->get('dispatcher')->setDefaultNamespace($this->ModuleName . "\Controllers");
       $di->get('view')->setViewsDir('../views/templates/' . $this->ModuleName);
       //重置视图主体
       $di->get('view')->setLayoutsDir('layout/');
       $di->get('view')->setTemplateAfter('layout');
   }**/

}