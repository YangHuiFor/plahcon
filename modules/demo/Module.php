<?php

/**
 * #====================================#
 * @todo 模块类
 * @author functions
 * @date 2014-11-20 
 * #====================================#
 */

namespace Demo;

use Common\AbstractModule;

class Module extends AbstractModule
{

    public function __construct()
    {
        $this->ModuleName = __NAMESPACE__;
        $this->ModuleDir = __DIR__;
    }

}
