<?php


namespace Core;


class servCheck extends serv_
{
    public static function mysql()
    {
        $result = dataCheck::mysql();
        return self::parse($result);
    }

    public static function redis()
    {
        $result = dataCheck::redis();
        return self::parse($result);
    }

    /**
     * @param unitResult $result
     * @return mixed
     */
    protected static function parse(unitResult $result)
    {
        return $result->data;
    }

}