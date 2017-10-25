<?php


namespace Admin\sign;


use Core\library\Email;
use Core\library\Tool;
use Core\unitInstance_;

class servEmail extends servAccount
{
    use unitInstance_;

    /**
     * @return self
     */
    public static function sole()
    {
        return self::_sole();
    }

    public static function checkEmailFormat($email):bool
    {
        if (strlen($email) < 6) {
            return false;
        }
        if (preg_match('#[\w+\.]+@\w+\.\w+#', $email)) {
            return false;
        }
        return true;
    }

    public function prepare($email)
    {
        $token = self::genToken($email); // use email as account
        $domain = \config::load('boot', 'public', 'domain');
        $link = Tool::makeURL($domain, '/sign-up', ['token' => $token]);
        $mailer = Email::SMTP('noreply');
        $mailer->Subject = \config::load('info', 'basic', 'project', '')." Sign-Up";
        $mailer->Body = \view::tpl('/sign/email-prepare')->with('link', $link)->res();
        $mailer->addAddress($email);
        $res = $mailer->send();
        return $res;
    }

    public function forgot($email)
    {
        $token = $this->genToken($email); // use email as account
        $domain = \config::load('boot', 'public', 'domain');
        $link = Tool::makeURL($domain, '/sign-reset', ['token' => $token]);
        $mailer = Email::SMTP('noreply');
        $mailer->Subject = \config::load('info', 'basic', 'project', '')." Sign-Forgot";
        $mailer->Body = \view::tpl('/sign/email-forgot')->with('link', $link)->res();
        $mailer->addAddress($email);
        $res = $mailer->send();
        return $res;
    }




}