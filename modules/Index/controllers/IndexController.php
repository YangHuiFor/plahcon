<?php

namespace Index\Controllers;
use Common\AbstractController;
use Common\functions;

class IndexController extends AbstractController
{

    public function indexAction()
    {
        //选择特定的模板
//        $this->view->pick('index/list');
        //禁止渲染主体模板LEVEL_LAYOUT
//        $this->view->disableLevel(3);
        // $a = new A();
        // $result= $a->select();

        $robots = new \Goods\Models\RobotsModel;
        // $res=$robots->get();
        // $res=$robots->getList();
        // $res = $robots::findFirst();
      	
        // foreach ($res->robotParts as $robotpart) {
        // 	echo $robotpart->parts->name;
        // }
        // die;
        $output = array(
        	'res' => $res
        	);
        $this->view->setVars($output);
   		// var_dump($res->toArray());die();

        // functions::dump($result->toArray());die;
    }

}

