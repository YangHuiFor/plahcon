<?php

namespace Goods\Models;

use \Common\AbstractModel;

class Parts extends AbstractModel
{

    public $id;

    public $name;

    public function initialize()
    {
        $this->hasMany("id", "RobotsParts", "parts_id");
        //必须继承
        parent::initialize();
    }

}