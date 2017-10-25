<?php

namespace Core;

trait unitInstance
{
    use unitInstance_;

    protected static $instances = [];

    final public static function instances()
    {
        return self::$instances;
    }

}