<?php

/**
 * #====================================#
 * @todo 模块文件
 * @author functions
 * @date 2014-11-20 
 * #====================================#
 */

namespace User;

use Common\AbstractModule;

class Module extends AbstractModule
{

    public function __construct()
    {
        $this->ModuleName = __NAMESPACE__;
        $this->ModuleDir = __DIR__;
    }
}