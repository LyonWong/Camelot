<?php


namespace Admin\sign;


use Admin\dataScopeUser;
use Admin\dataUserAuth;
use Admin\dataUser;
use Admin\serv_;
use Core\library\Tool;
use Admin\data;
use Core\unitInstance;

class servAccount extends serv_
{
    use unitInstance;

    /**
     * @return self
     */
    public static function sole()
    {
        return self::_sole();
    }


    public function genToken($email)
    {
        $token = Tool::genSecret(32, Tool::STR_FORMAL);
        $redisKey = data::RDS_SIGN . $token;
        data::redis()->set($redisKey, $email, SECONDS_HOUR);
        return $token;
    }

    public function verToken($token)
    {
        $redisKey = data::RDS_SIGN . $token;
        return data::redis()->get($redisKey);
    }

    public function ifAccountExists($account): bool
    {
        $res = dataUserAuth::sole()->search(dataUserAuth::TYPE_ACCOUNT, $account);
        return boolval($res);
    }

    public static function checkPasswordFormat($password): bool
    {
        if (strlen($password) < 6) {
            return false;
        }
        if (preg_match('#[^\d]#', $password) == 0) {
            return false;
        }
        return true;
    }


    public function create($account, $password)
    {
        $uid = dataUser::sole()->append($account); //set name same
        if (!$uid) {
            \servException::halt('Failed to add new user');
        }
        $passhash = password_hash($password, PASSWORD_DEFAULT);
        if (!dataUserAuth::sole()->append(dataUserAuth::TYPE_ACCOUNT, $uid, $account, $passhash)) {
            \servException::halt("Failed to set auth of `$account`");
        }
        dataScopeUser::sole()->insert([
            'uid' => $uid,
            'groups' => '[]',
            'auths' => '{}'
        ]);
        return $uid;
    }

    public function reset($account, $password)
    {
        $daoUserAuth = dataUserAuth::sole();
        $id = $daoUserAuth->search(dataUserAuth::TYPE_ACCOUNT, $account)['id'] ?? 0;
        return (bool)$daoUserAuth->update(
            ['code' => password_hash($password, PASSWORD_DEFAULT)],
            ['id' => $id]
        )->rowCount();
    }

    /**
     * @param $account
     * @param $password
     * @return bool|int uid on success
     */
    public static function verify($account, $password)
    {
        $res = dataUserAuth::sole()->search(dataUserAuth::TYPE_ACCOUNT, $account);
        if (password_verify($password, $res['code'])) {
            return $res['uid'];
        } else {
            return false;
        }
    }
}