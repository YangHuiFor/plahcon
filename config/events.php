<?php
/**
 * #====================================#
 * @todo 事件管理，用于引导di注册
 * @author functions
 * @date 2014-11-20
 * #====================================#
 */

return [
    'dispatch' => [
    	'beforeException' => 'Plugin\ExceptionMonitorPlugins',
    ],
];