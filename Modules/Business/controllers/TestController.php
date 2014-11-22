<?php


namespace Goods\Controllers;
use Common\AbstractController;
use Phalcon\Mvc\View;

// use Goods\Models\Robots;
// use Goods\Models\Parts;
// use Goods\Models\RobotsParts;
class TestController extends AbstractController
{

    public function indexAction()
    {	

    	$robots = new \Goods\Models\RobotsModel;
   		$res=$robots->get();
   		var_dump($res->toArray());
        $this->view->disableLevel(4);
    }


    public function saveAction()
    {
    	$this->flash->success("The post was correctly saved!");
    	return $this->response->redirect("goods/index/index");
    }
}

