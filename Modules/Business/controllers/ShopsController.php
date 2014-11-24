<?php

/**
 * #====================================#
 * @todo 商铺控制器
 * @author functions
 * @date 2014-11-20
 * #====================================#
 */

namespace Business\Controllers;

use Business\Forms\addForm;
use Common\AbstractController;
use Common\functions;

class ShopsController extends AbstractController
{

    public function initialize()
    {
        //设置页面标题
        $this->tag->setTitle("商家列表");
    }

    public function indexAction()
    {
        $form = new addForm();
        functions::debug('test');
        $this->view->form = $form;
    }

    public function listAction()
    {
        // var_dump($this->router);die;
        // var_dump($this->view);die();
    }

}

