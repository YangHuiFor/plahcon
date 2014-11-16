<?php

namespace Demo\Models;

use \Common\AbstractModel;

class PartsModel extends AbstractModel
{

    public $id;

    public $name;

    public function initialize()
    {
        $this->hasMany("id", "Demo\Models\RobotsParts", "parts_id");
        //设置查询库
        // $this->setSchema ('vp_basic');
        //必须继承
        parent::initialize();
    }

}