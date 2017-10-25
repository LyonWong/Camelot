<?php


namespace Admin;

use Core\unitInstance;

class servUser extends serv_
{
    use unitInstance;

    /**
     * @return self
     */
    public static function sole()
    {
        return self::_sole();
    }

    public function sn2id($usn)
    {
        return dataUser::sole()->fetchOne('id', ['sn'=>$usn], 0);
    }

    public function id2sn($uid)
    {
        return dataUser::sole()->fetchOne('sn', ['id' => $uid], 0);
    }

    public function id2name($uid)
    {
        return dataUser::sole()->fetchOne('name', ['id' => $uid], 0);
    }

}