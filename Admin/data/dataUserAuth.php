<?php


namespace Admin;


use Core\unitInstance;


class dataUserAuth extends dataSole
{
    use unitInstance;

    const TABLE = 'user_auth';

    const TYPE_ACCOUNT = 1;
    const TYPE_WEIXIN = 2;

    /**
     * @return self
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

    public function append($iType, $uid, $uaid, $code, $expire = 0, array $extra = [])
    {
        $this->mysql->insert(self::TABLE, [
            'i_type' => $iType,
            'uid' => $uid,
            'uaid' => $uaid,
            'code' => $code,
            'expire' => $expire,
            'extra' => json_encode($extra, JSON_FORCE_OBJECT)
        ]);
        return self::mysql()->lastInsertId();
    }

    public function search($iType, $uaid)
    {
        $res = $this->mysql->select(self::TABLE, ['id', 'uid', 'code', 'extra'], [
            'i_type' => $iType,
            'uaid' => $uaid,
        ])->fetch();
        return $res;
    }

    public function updateByUaid($uaid, $field, $value): bool
    {
        $res = $this->mysql->update(self::TABLE, [$field => $value], ['uaid' => $uaid])->rowCount();
        return (bool)$res;
    }
}
