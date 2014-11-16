<?php

/**
 * Created by PhpStorm.
 * User: ��
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
     * @todo ��ȡ����Դ��
     */
    public function getSource()
    {				   
    	//��ǰ׺
    	$this->_table_prefix = $this->getDI()->get("config")->database->prefix;
    	//�ۺϱ�ǰ׺�ͱ���
    	$namespaceArr = explode("\\",get_class($this));
    	if (isset($namespaceArr[2])) {
    		//����model��׺
    		$tableName = str_replace("Model", "", $namespaceArr[2]);
    		//��дת����Сд��_
    		$tableName = Text::uncamelize($tableName);
    		$sourceName =  $this->_table_prefix . $tableName;
    		return $sourceName;
    	}
    }

} 