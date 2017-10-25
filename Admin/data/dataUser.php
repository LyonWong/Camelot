<?php


namespace Admin;


use Core\unitInstance;

class dataUser extends dataSole
{
    use unitInstance;

    const TABLE = 'user';

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

    public function append($name, $info = '{}'): int
    {
        $data = [
            'name' => $name,
            'info' => $info,
        ];
        $try = 10;
        do {
            $data['sn'] = $this->uniqueSN(self::SN_USER);
            self::mysql()->insert(self::TABLE, $data);
            $uid = (int)self::mysql()->lastInsertId();
            if (--$try < 0) {
                return false;
            }
        } while (!$uid);
        return $uid;
    }

}