<?php

namespace Demo\Models;
use \Common\AbstractModel;

class RobotsPartsModel extends AbstractModel
{

    public $id;

    public $robots_id;

    public $parts_id;

    public function initialize()
    {
        $this->belongsTo("robots_id", "Demo\Models\RobotsModel", "id",['alias' => 'robot']);
        $this->belongsTo("parts_id", "Demo\Models\PartsModel", "id",['alias' => 'parts']);
        // $this->setSchema ('vp_basic');
        //必须继承
        parent::initialize();
    }

    public function get()
    {

    }
}