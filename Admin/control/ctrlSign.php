<?php


namespace Admin;


use Admin\sign\servAccount;
use Admin\sign\servEmail;
use Core\unitAPI;
use Core\unitDoAction;
use Core\unitHttp;
use Core\library\Tool;

class ctrlSign extends ctrl_
{
    use unitDoAction;
    use unitHttp;
    use unitAPI;

    const ERR_ACCOUNT_OR_PASSWORD_ERROR = ['1', 'Account or password error'];
    const ERR_FORBIDDEN_IP = ['1', 'Your IP `%s` is forbidden to visit.'];
    const ERR_EMAIL_NOT_SEND = ['1', 'Failed to send email'];
    const ERR_ACCOUNT_NOT_EXISTS = ['1', "Account `%s` not exists"];
    const ERR_PASSWORD_TOO_SIMPLE = ['1', 'Password too simple'];
    const ERR_ACCOUNT_OR_TOKEN_ERROR = ['1', 'Account or token error'];
    const ERR_PASSWORD_FORMAT_ILLEGAL = ['1', 'Password format illegal'];
    const ERR_UNKNOWN_ERROR = ['1', 'Unknown error'];

    public function _DO_in()
    {
        $callbackURI = \input::get('callbackURI')->value();
        $ip = \input::ip();
        $allowedIPs = \config::load('option', 'allowed', 'register.IPs', []);
        $showCreate = Tool::IPcheck($ip, $allowedIPs);
        \view::tpl('/sign/in')
            ->with('showCreate', $showCreate)
            ->with('callbackURI', $callbackURI);
    }

    public function _POST_in()
    {
        $account = \input::post('account')->value();
        $password = \input::post('password')->value();
        if ($uid = servEmail::verify($account, $password)) {
            $usn = servUser::sole()->id2sn($uid);
            $auth = servSession::sole()->start($usn);
            setcookie(SESSION_AUTH, $auth, 0, '/', '', false, true);
            $this->apiSuccess();
        } else {
            $this->apiFailure(self::ERR_ACCOUNT_OR_PASSWORD_ERROR);
        }
    }


    public function _DO_prepare()
    {
        $ip = \input::ip();
        $allowedIPs = \config::load('option', 'allowed', 'register.IPs', []);
        if (!Tool::IPcheck($ip, $allowedIPs)) {
            \viewException::halt("Forbidden IP", 403);
        }
        \view::tpl('/sign/prepare');
    }

    public function _POST_prepare()
    {
        $ip = \input::ip();
        $allowedIPs = \config::load('option', 'allowed', 'register.IPs', []);
        if (!Tool::IPcheck($ip, $allowedIPs)) {
            $this->apiFailure(self::ERR_FORBIDDEN_IP, [$ip]);
        }
        $email = \input::post('email')->value();
        if (servEmail::sole()->prepare($email)) {
            $this->apiSuccess();
        } else {
            $this->apiFailure(self::ERR_EMAIL_NOT_SEND);
        }
    }

    public function _DO_forgot()
    {
        \view::tpl('/sign/forgot');
    }

    public function _POST_forgot()
    {
        $email = \input::post('email')->value();
        if (!servEmail::sole()->ifAccountExists($email)) {
            $this->apiFailure(self::ERR_ACCOUNT_NOT_EXISTS, [$email]);
        } else if (servEmail::sole()->forgot($email)) {
            $this->apiSuccess();
        } else {
            $this->apiFailure(self::ERR_EMAIL_NOT_SEND);
        }
    }

    public function _DO_reset()
    {
        $token = \input::get('token')->value();
        $email = servAccount::sole()->verToken($token);
        \view::tpl('/sign/reset')
            ->with('email', $email)
            ->with('token', $token);
    }

    public function _POST_reset()
    {
        $token = \input::post('token')->value();
        $email = servEmail::sole()->verToken($token);
        $password = \input::post('password')->value();
        if (servEmail::checkPasswordFormat($password) == false) {
            $this->apiFailure(self::ERR_PASSWORD_TOO_SIMPLE);
        }
        if (servEmail::sole()->reset($email, $password)) {
            $this->apiSuccess();
        } else {
            $this->apiFailure();
        }
    }

    public function _DO_up()
    {
        $token = \input::get('token')->value();
        $email = servEmail::sole()->verToken($token);
        \view::tpl('/sign/up')
            ->with('email', $email)
            ->with('token', $token);
    }

    public function _POST_up()
    {
        $token = \input::post('token')->value();
        $email = servEmail::sole()->verToken($token);
        $password = \input::post('password')->value();
        if (!$email) {
            $this->apiFailure(self::ERR_ACCOUNT_OR_TOKEN_ERROR);
        }
        if (servEmail::checkPasswordFormat($password) == false) {
            $this->apiFailure(self::ERR_PASSWORD_FORMAT_ILLEGAL);
        }
        if (!servEmail::sole()->create($email, $password)) {
            $this->apiFailure(self::ERR_UNKNOWN_ERROR);
        }
        $this->apiSuccess();
    }

    public function _DO_out()
    {
        servSession::sole()->close();
        setcookie(SESSION_AUTH, '', -1);
        $this->httpLocation('/sign-in');
    }

}