<?php

/**
 * @todo 通用函数库
 * @author functions
 * @date 2014-11-10
 */
namespace Common;
class functions
{

    /**
     * @todo 打印
     */
    public static function dump()
    {
        $argument = func_get_args();
        echo "<pre>";
        print_r($argument);
        echo "</pre>";
    }
}