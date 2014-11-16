<?php

namespace Demo\Controllers;

use Common\AbstractController;
use Common\functions;
use Engine\Db\Connection;

class ErrorsController extends AbstractController
{
    
    public function initialize()
    {
        $views = $this->getDI()->get("config")->views;
        $this->view->setViewsDir($views->errors);
    }

    public function show404Action()
    {  
        $this->view->pick('show404');
    }

    public function show401Action()
    {

    }

    public function show500Action()
    {
        $this->view->pick('show500');
    }
}

