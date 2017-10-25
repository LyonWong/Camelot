<?php


namespace Admin;


use Core\unitInstance;

class servScope extends serv_
{
    use unitInstance;

    protected $name;

    /**
     * @param $name
     * @return servScope
     */
    public static function sole($name)
    {
        return self::_sole($name);
    }

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function setUserAuths($uid, array $auths = [])
    {
        $res = dataScopeUser::sole()->update([
            'auths' => json_encode($auths, JSON_FORCE_OBJECT)
        ], ['uid' => $uid]);
        return boolval($res);
    }

}