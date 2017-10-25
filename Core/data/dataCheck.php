<?php


namespace Core;


class dataCheck
{
    public static function mysql()
    {
        $result = unitResult::inst();
        try {
            data::mysql()->PDO()->getAttribute(\PDO::ATTR_SERVER_INFO);
            return $result->ok("Mysql is running.");
        } catch (\PDOException $e) {
            return $result->err($e->getMessage());
        }
    }

    public static function redis()
    {
        $result = unitResult::inst();
        try {
            data::redis()->info();
            return $result->ok("Redis is running.");
        } catch (\RedisException $e) {
            return $result->err($e->getMessage());
        }
    }

}