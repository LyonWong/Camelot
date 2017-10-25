<?php

namespace Admin;

use Core\library\Mysql;
use Core\library\Redis;

class data_
{
    const SN_USER = 'U';

    const RDS_SESSION = 'SESS_';
    const RDS_SIGN = 'SIGN_';

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


    protected function uniqueSN($type)
    {
        return uniqid($type);
    }
}