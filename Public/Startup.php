<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Startup
 *
 * @author 辉
 */
use Phalcon\Config;

class Startup
{

    //配置文件目录
    const APP_CONFIG_PATH = "/Config/";
    const APP_BOOTSTRAP = 'Bootstrap';

    protected $config;

    public function __construct()
    {
        $this->registerConfig();
        $this->loadBootstrap();
    }

    /**
     * @todo 初始化
     * @return \self
     */
    public static function init()
    {
        return new self;
    }

    /**
     * @todo 获取环境配置
     * @return type
     */
    public function getEnvConfig()
    {
        $config = include APP_PATH . self::APP_CONFIG_PATH . '/' . APP_ENV . '.php';
        return $config;
    }

    /**
     * @todo 获取应用配置
     * @return array
     */
    public function getApplicationConfig()
    {
        $application = include APP_PATH . self::APP_CONFIG_PATH . '/application.php';
        return $application;
    }

    /**
     * @todo 注册配置
     * @return \Startup
     */
    public function registerConfig()
    {
        $envConfig = $this->getEnvConfig();
        $applicationConfig = $this->getApplicationConfig();
        $this->config = new Config(array_merge($envConfig, $applicationConfig));
        return $this;
    }

    /**
     * @todo 载入引导
     * @throws \Exception
     */
    public function loadBootstrap()
    {
        if ($this->config->path->wf) {
            require $this->config->path->wf . self::APP_BOOTSTRAP . '.php';
        } else {
            throw new \Exception('缺少框架必要引导文件');
        }
    }

    /**
     * @todo 启动
     * @return \Startup
     */
    public function startup()
    {
        \Phalcon\Bootstrap::init($this->config)->startup();
        return $this;
    }

}
