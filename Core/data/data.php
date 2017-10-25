<?php


namespace Core;


class data extends data_
{
    public static function mysqlInfo()
    {
        return self::mysql()->run("select version()")->fetch(0);
    }

    public static function redisInfo()
    {
        return self::redis()->info();
    }


}