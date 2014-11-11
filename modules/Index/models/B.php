<?php
/**
 * Created by PhpStorm.
 * User: 辉
 * Date: 2014/11/10
 * Time: 19:33
 */

namespace Index\Models;

use Common\AbstractModel;

class B extends AbstractModel
{

    public function initialize()
    {
        // $this->className = ltrim(str_replace("Model",'',str_replace(__NAMESPACE__, '', __CLASS__)), "\\");
        $this->className = ltrim(str_replace(__NAMESPACE__, '', __CLASS__), "\\");
        $this->belongsTo("id", "A", "id");
    }

    public function select()
    {
//        return $this->query('SELECT * FROM t_a')->execute();
        return $this->find();
    }
} 