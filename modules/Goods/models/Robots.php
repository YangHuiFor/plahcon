<?php
namespace Goods\Models;

use Phalcon\Mvc\Model\Validator\InclusionIn,
    Phalcon\Mvc\Model\Validator\Uniqueness;
class Robots extends \Phalcon\Mvc\Model
{
    public $id;

    public $name;
    public $type;

    public function initialize()
    {
        $this->hasMany("id", "RobotsParts", "robots_id");
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
}