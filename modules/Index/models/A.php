<?php
/**
 * Created by PhpStorm.
 * User: 辉
 * Date: 2014/11/10
 * Time: 19:33
 */

namespace Index\Models;

use Common\AbstractModel;

class A extends AbstractModel
{

    public function initialize()
    {
        // $this->className = ltrim(str_replace("Model",'',str_replace(__NAMESPACE__, '', __CLASS__)), "\\");
        $this->className = ltrim(str_replace(__NAMESPACE__, '', __CLASS__), "\\");
        $this->hasOne("id", "B", "a_id");
    }

    public function select()
    {
       // return $this->query('SELECT * FROM t_a')->execute();
       // $result = $this->find();
       $result = $this->findFirst();
       \Common\functions::dump($result->toArray());

       foreach ($result->b as $robotPart) {
		    echo $robotPart->fadf, "\n";
		}
       die;
  
    }
} 