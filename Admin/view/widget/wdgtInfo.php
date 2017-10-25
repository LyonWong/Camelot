<?php


namespace Admin;


class wdgtInfo
{
    public static function basic($item)
    {
        return \config::load('info', 'basic', $item, "`$item`");
    }

}