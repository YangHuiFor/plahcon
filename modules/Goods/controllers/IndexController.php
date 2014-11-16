<?php


namespace Goods\Controllers;
use Common\AbstractController;
use Phalcon\Mvc\View;

// use Goods\Models\Robots;
// use Goods\Models\Parts;
// use Goods\Models\RobotsParts;
class IndexController extends AbstractController
{

    public function indexAction()
    {	

    	// $robot = Robots::findFirst();
    	// \Common\functions::dump($robot->toArray());die;
   //  	$robotsParts = $robot->robotsParts; // all the related records in RobotsParts
   //  	\Common\functions::dump($robotsParts->toArray());die;
			// foreach ($robot->robotsParts as $robotPart) {
			//     echo $robotPart->parts->name, "\n";
			// }
    	// $robots = Robots::query()
    	// 	->join()
		   //  ->where("type = :type:")
		   //  ->andWhere("year < 2000")
		   //  ->bind(array("type" => "1"))
		   //  ->execute();
    	// $name = "root2";
		// $robot = Robots::findFirstByName($name);
		// $robot = Robots::findFirstByType(3);
		// $robot = Robots::findByType(3);
		// $robot = Robots::find()->filter(function($robots) {
		//     //Return only customers with a valid e-mail
		//     if($robots->type == 3) {
		//     	// var_dump($robots->toArray());
		// 		return $robots;
		//     }
		// });
		// $robot->save();
		    // \Common\functions::dump($robot->toArray());die;

		// $robot = new Robots;
		// $robot->name='test1';
		// $robot->year='2014';
		// $robot->save();

        $this->view->disableLevel(4);
    }

}

