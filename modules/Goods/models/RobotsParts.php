<?php

namespace Goods\Models;
use \Common\AbstractModel;

class RobotsParts extends AbstractModel
{

    public $id;

    public $robots_id;

    public $parts_id;

    public function initialize()
    {
        $this->belongsTo("robots_id", "Robots", "id");
        $this->belongsTo("parts_id", "Parts", "id");
        //必须继承
        parent::initialize();
    }

}