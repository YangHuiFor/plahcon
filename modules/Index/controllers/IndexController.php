<?php

namespace Index\Controllers;
use Common\AbstractController;
use Index\Models\A;
use Index\Models\AModel;
use Common\functions;

class IndexController extends AbstractController
{

    public function indexAction()
    {
        //选择特定的模板
//        $this->view->pick('index/list');
        //禁止渲染主体模板LEVEL_LAYOUT
//        $this->view->disableLevel(3);
        $a = new AModel();
        $result= $a->select();
        functions::dump($result->toArray());die;
    }

}

