<?php

/**
 * @todo db�����Լ��򵥵Ķ�д����
 */

namespace Engine\Db;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as FileLogger;

trait Connection 
{

	protected $_config;
	protected $_di;
	protected $_db_servers_hosts;
	protected $_master_host;
	protected $_slave_host;



	public function _initConnection()
	{
		$this->_di = $this->getDI();
		$this->_config = $this->_di->get("config");
		$this->_db_servers_hosts = $this->_config->database->host->toArray();
		$this->setMasterServers();
		$this->setSlaveServers();
	}


	public function setMasterServers()
	{	
		$this->getMasterHost();
		$dbConfig = [
			'host' => $this->_master_host,
			'username' => $this->_config->database->username,
			'password' => $this->_config->database->password,
			'dbname' => $this->_config->database->dbname,
			'charset' => $this->_config->database->charset
		];
		$this->_di->set("db", $this->connection($dbConfig));
	}

	public function getMasterHost()
	{
		$this->_master_host = current($this->_db_servers_hosts);
	}

	
	
	public function setSlaveServers()
	{
		$this->getSlaveHost();
		$dbConfig = [
			'host' => $this->_slave_host,
			'username' => $this->_config->database->username,
			'password' => $this->_config->database->password,
			'dbname' => $this->_config->database->dbname,
			'charset' => $this->_config->database->charset
		];
		$this->_di->set("dbSlave", $this->connection($dbConfig,'dbSlave'));

	}

	public function getSlaveHost()
	{	
		$masterServersHosts = array_shift($this->_db_servers_hosts);
		if(empty($this->_db_servers_hosts)) {
			$this->_slave_host = $masterServersHosts;
		} else {
			$this->_slave_host = $this->_db_servers_hosts[array_rand($this->_db_servers_hosts)];
		}
	}

	public function connection(array $config, $serversType='db')
	{	
		$connection = new DbAdapter($config);
		$debug = $this->_config->application->debug;
		if ($debug) {
		    $eventsManager = new EventsManager();
		    $logger = new FileLogger($this->_config->application->logsDir . "sql-{$serversType}.log");

		    $eventsManager->attach(
		        'db',
		        function ($event, $connection) use ($logger) {
		            if ($event->getType() == 'beforeQuery') {
		                $variables = $connection->getSQLVariables();
		                if ($variables) {
		                    $logger->log($connection->getSQLStatement() . ' [' . join(',', $variables) . ']', \Phalcon\Logger::INFO);
		                } else {
		                    $logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
		                }
		            }
		        }
		    );
		    $connection->setEventsManager($eventsManager);
		}
		return $connection;
	}
}



