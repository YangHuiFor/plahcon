<?php


namespace Goods\Controllers;
use Common\AbstractController;
use Phalcon\Mvc\View;
class IndexController extends AbstractController
{

    public function indexAction()
    {
        $this->view->disableLevel(4);
    }

}

