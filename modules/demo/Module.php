<?php

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