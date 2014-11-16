<?php

/**
 * Created by PhpStorm.
 * User: 辉
 * Date: 2014/11/10
 * Time: 19:17
 */

namespace Common;

use Phalcon\Mvc\Model;
use Phalcon\Text;
use Engine\Db\Connection;

class AbstractModel extends Model
{   
    use Connection;
    public $_class_name;
    public $_table_prefix;


    public function initialize()
    {
    	$this->_initConnection();
        $this->setReadConnectionService("dbSlave");
    }

    /**
     * @todo 获取表资源名
     */
    public function getSource()
    {				   
    	//表前缀
    	$this->_table_prefix = $this->getDI()->get("config")->database->prefix;
    	//聚合表前缀和表面
    	$namespaceArr = explode("\\",get_class($this));
    	if (isset($namespaceArr[2])) {
    		//过滤model后缀
    		$tableName = str_replace("Model", "", $namespaceArr[2]);
    		//大写转换成小写加_
    		$tableName = Text::uncamelize($tableName);
    		$sourceName =  $this->_table_prefix . $tableName;
    		return $sourceName;
    	}
    }

} 