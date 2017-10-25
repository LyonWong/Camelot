<?php

namespace Core;

use Core\library\Mysql;
use Core\library\Redis;

class data_
{


    public function __construct()
    {
    }

    /**
     * @param string $index
     * @return Mysql|mixed
     */
    public static function mysql($index = 'default')
    {
        return Mysql::inst($index);
    }

    public static function redis($index = 'default')
    {
        return Redis::inst($index);
    }
}