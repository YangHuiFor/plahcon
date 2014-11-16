<?php

namespace Index\Models;

use \Common\AbstractModel;

class PartsModel extends AbstractModel
{

    public $id;

    public $name;

    public function initialize()
    {
        $this->hasMany("id", "RobotsParts", "parts_id");
        $this->setSchema ('vp_basic');
        //必须继承
        parent::initialize();
    }

}