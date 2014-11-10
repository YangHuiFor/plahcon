<?php

/**
 * Created by PhpStorm.
 * User: 辉
 * Date: 2014/11/10
 * Time: 19:17
 */

namespace Common;

use Phalcon\Mvc\Model;

class AbstractModel extends Model
{
    public $className;

    public function getSource()
    {
        return 't_' . strtolower($this->className);
    }

//    public function initialize()
//    {
////        $this->className = ltrim(str_replace("Model",'',str_replace(__NAMESPACE__, '', __CLASS__)), "\\");
//    }
} 