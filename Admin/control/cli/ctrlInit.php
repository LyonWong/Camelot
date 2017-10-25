<?php


namespace Admin\cli;


use Admin\data;
use Admin\servAccess;
use Admin\servScope;
use Admin\sign\servAccount;

class ctrlInit extends ctrl_
{
    public function _DO_()
    {
        $this->_DO_db();
        $this->_DO_scope();
        echo "Init finished.".LF;
        echo "Please run `/cli/init-root` to create administrator.".LF;
    }

    public function _DO_db()
    {
        $file  = PATH_ROOT.'/'.SPACE.'/file/database.sql';
        $source = file_get_contents($file);
        data::mysql()->PDO()->exec($source);
    }

    public function _DO_scope()
    {
        $ctrl = new ctrlScope();
        $ctrl->_DO_load(servAccess::SCOPE_ADMIN);
    }

    public function _DO_root()
    {
        $account = \input::cli('account')->value(true);
        $password = \input::cli('password')->value(true);
        $uid = servAccount::sole()->create($account, $password);
        if ($uid) {
            $res = servScope::sole(servAccess::SCOPE_ADMIN)->setUserAuths($uid, ['admin' => ['*' => '-1']]);
            if ($res) {
                echo "create super user: `$account` with all authority successfully.".LF;
            } else {
                echo "create user but faied tu set auths".LF;
            }
        } else {
            echo "Failed to create account.".LF;
        }

    }

}