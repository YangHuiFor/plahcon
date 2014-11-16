<?php

namespace Index\Models;
use \Common\AbstractModel;

class RobotsPartsModel extends AbstractModel
{

    public $id;

    public $robots_id;

    public $parts_id;

    public function initialize()
    {
        $this->belongsTo("robots_id", "Goods\Models\RobotsModel", "id",['alias' => 'Robot']);
        $this->belongsTo("parts_id", "Index\Models\PartsModel", "id",['alias' => 'parts']);
        $this->setSchema ('vp_basic');
        //必须继承
        parent::initialize();
    }

    public function get()
    {

    }
}