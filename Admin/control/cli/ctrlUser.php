<?php


namespace Admin\cli;


use Admin\sign\servAccount;
use Admin\servUser;
use Admin\sign\servEmail;

class ctrlUser extends ctrl_
{
    public function _DO_create()
    {
        $account = \input::cli('account')->value(true);
        $password = \input::cli('password')->value(true);

        $uid = servAccount::sole()->create($account, $password);

        if (!$uid) {
            echo "Create user failed.";
        }
    }

    public function _DO_prepare()
    {
        $email = \input::cli('email')->value(true);
        $res = servEmail::sole()->prepare($email);
        var_dump($res);
    }

    public function _DO_reset()
    {
        $account = \input::cli('account')->value(true);
        $password = \input::cli('password')->value(true);

        servAccount::resetPassword($account,$password);
        //todo reset之后，原有的会话依然是有效的
    }

    public function _DO_scope()
    {
        $uid = \input::cli('uid')->value(true);
        $field = \input::cli('field')->value(true);
        $point = \input::cli('point')->value(true);
        $priv = \input::cli('priv')->toInt();
        servUser::sole()->setScopeAuth($field, $point, $priv);
    }

    public function _DO_group()
    {
        $uid = \input::cli('uid')->value(true);
        $groups = \input::cli('groups')->value(true);
        servUser::sole($uid)->setScopeGroup($groups);
    }

}