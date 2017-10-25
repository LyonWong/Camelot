<?php


namespace Admin;


class wdgtUser
{
    public static function name()
    {
        $uid = servSession::sole()->uid();
        return servUser::sole()->id2name($uid);
    }

}