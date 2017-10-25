<?php


namespace Admin;


use Core\unitMysqlSole;

/**
 * @property \Core\library\Mysql mysql
 */
class dataSole extends data_
{
    use unitMysqlSole;

    public function __construct()
    {
        $this->mysql = data::mysql();
    }

}