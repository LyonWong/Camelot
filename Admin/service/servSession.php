<?php


namespace Admin;


use Core\unitInstance;

class servSession extends serv_
{
    use unitInstance;

    const EXPIRE = SECONDS_DAY * 30;

    /**
     * @var servAccess
     */
    public $access;

    public $lang;

    public $scopeKey;

    protected $usn;

    protected $uid;

    /**
     * @return servSession
     */
    public static function sole()
    {
        return self::_sole();
    }

    public function usn()
    {
        return $this->usn;
    }

    public function uid()
    {
        return $this->uid;
    }

    public function start($usn)
    {
        $this->usn = $usn;
        $token = uniqid(crc32($usn), true);
        $redisKey = $this->redisKey($usn);
        data::redis()->hSet($redisKey, self::clientFlag(), $token);
        data::redis()->expire($redisKey, self::EXPIRE);
        return self::spliceAuth($usn, $token);
    }

    /**
     * verify user and return uid if success
     * @param $auth
     * @return bool|int
     */
    public function identify($auth)
    {
        $token = data::redis()->hGet($this->redisKey($auth['usn']), self::clientFlag());
        if ($auth['token'] === $token) {
            return $this->uid = servUser::sole()->sn2id($auth['usn']);
        } else {
            return false;
        }
    }

    public function close()
    {
        return data::redis()->del($this->redisKey($this->usn));
    }

    protected function redisKey($usn)
    {
        return data::RDS_SESSION . $usn;
    }

    public static function parseAuth($auth)
    {
        list($usn, $token) = explode('-', $auth);
        return [
            'usn' => $usn,
            'token' => $token,
        ];

    }

    public static function spliceAuth($usn, $token)
    {
        return "$usn-$token";
    }

    public static function clientFlag()
    {
        return 'F_' . base_convert(crc32($_SERVER['HTTP_USER_AGENT']), 10, 32);
    }

}


