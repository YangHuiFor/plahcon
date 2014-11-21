<?php

namespace Demo\Controllers;

use Common\AbstractController;
use Common\functions;
use Engine\Db\Connection;

class IndexController extends AbstractController
{

    // use Connection;

    public function indexAction()
    {
        //选择特定的模板
        //$this->view->pick('index/list');
        //禁止渲染主体模板LEVEL_LAYOUT
        //$this->view->disableLevel(3);
        //跨模块使用model
//        $robots = new \Demo\Models\RobotsModel;
//        $res = $robots->get();
        // $res=$robots->getList();
        // $res = $robots::findFirst();
//        var_dump($res->toArray());
//        die;
//        $output = array(
//            'res' => $res
//        );
//        $this->view->setVars($output);
        // var_dump($res->toArray());die();
        // functions::dump($result->toArray());die;
    }

    public function saveAction()
    {
        // $this->registerDb();
        $robots = new \Demo\Models\RobotsModel;
        // die;
        $robots->type = 'Mechanical';
        $robots->name = 'valid';
        // $robots->year = 22;
        if ($robots->save()) {
            echo "ok";
        } else {
            echo "faild";
            var_dump($robots->getWriteConnection());
            foreach ($robots->getMessages() as $message) {
                echo $message;
            }
        }

        exit();
    }

    public function listAction()
    {
        throw new \Exception("Error Processing Request", 1);
    }

    public function updateAction()
    {
        $one = (new \Demo\Models\RobotsModel)->findFirst();
        // foreach ($one->robotParts as $robotParts) {
        //     echo $robotParts->parts->name;die;
        //     $robotParts->parts->name = 'update';
        //     $robotParts->parts->update();
        // }
        // $one->getRobotParts();
        // var_dump($one->getRobotParts());
        foreach ($one->robotParts as $robotParts) {
            $robotParts->name = 'update2';
            $robotParts->update();
        }
        var_dump($one->robotParts->toArray());
        die;
    }

}
