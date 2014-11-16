<?php
namespace Goods\Models;

use Phalcon\Mvc\Model\Validator\InclusionIn,
    Phalcon\Mvc\Model\Validator\Uniqueness;
use \Common\AbstractModel;

class RobotsModel extends AbstractModel
{
    public $id;

    public $name;
    public $type;

    public function initialize()
    {
        $this->hasMany("id", "Index\Models\RobotsPartsModel", "robots_id",['alias' => 'robotParts']);
        //必须继承
        parent::initialize();

    }

     public function beforeSave()
    {
        //Convert the array into a string
        // $this->type = 10;
    }


    public function validation()
    {

        $this->validate(new InclusionIn(
            array(
                "field"  => "type",
                "domain" => array("Mechanical", "Virtual")
            )
        ));

        $this->validate(new Uniqueness(
            array(
                "field"   => "name",
                "message" => "The robot name must be unique"
            )
        ));

        return $this->validationHasFailed() != true;
    }

    public function get()
    {
        return $this->find();
    }


    public function getList()
    {   


        $result = $this->_modelsManager->createBuilder()
                ->from(['r'=>"Goods\Models\RobotsModel"])
                ->join("Index\Models\RobotsPartsModel",'rp.robots_id=r.id','rp','right')
                ->getQuery()
                ->execute();
                return $result;
    }
}