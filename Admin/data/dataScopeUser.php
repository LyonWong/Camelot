<?php


namespace Admin;

use Core\unitInstance;

class dataScopeUser extends dataSole
{
    use unitInstance;


    const TABLE = 'scope_user';

    /**
     * @return self:q
     * :q
     *
     */
    public static function sole()
    {
        return self::_sole();
    }

    public function __construct()
    {
        parent::__construct();
        $this->TABLE = self::TABLE;
    }

    public function fetchByUid($uid):array
    {
        $res = $this->fetchOne(['groups', 'auths'], ['uid'=>$uid]);
        $res['groups'] = isset($res['groups']) ? json_decode($res['groups'], true) : [];
        $res['auths'] = isset($res['auths']) ? json_decode($res['auths'], true) : [];
        return $res;
    }

}