<?php


namespace Admin;

use Core\library\Language;
use Core\unitDoAction;
use Core\unitHttp;

class ctrlSession extends ctrl_
{
    use unitDoAction;
    use unitHttp;

    protected $uid;

    protected $clientFlag;

    protected $scopeKey;

    public function __construct()
    {
        parent::__construct();
        $this->clientFlag = base_convert(crc32($_SERVER['HTTP_USER_AGENT']), 10, 32);
    }

    public function runBefore():bool
    {
        if (!parent::runBefore()) {
            return false;
        };

        $sessionAuth = self::parse();

        if ($sessionAuth && $uid = servSession::sole()->identify($sessionAuth)
        )   {
            $this->uid = $uid;
        }else {
            $callbackURI = urlencode(strstr($this->_URI_, '/sign-in') === 0 ? '/' : $this->_URI_); //avoid sign-in loop
            $redirectURI = "/sign-in?callbackURI=$callbackURI";
            $this->httpLocation($redirectURI);
            return false;
        }

        $srvSession = servSession::sole();
        $srvSession->scopeKey = $this->scopeKey ?: str_replace('/','-', trim($this->_WAY_, '/')) ?: '_';
        $srvSession->access = servAccess::sole($this->uid, servAccess::SCOPE_ADMIN)->assign('admin');
        $srvSession->access->checkView($srvSession->scopeKey);
        $srvSession->lang = \input::cookie('lang', Language::detect())->value();

        return true;
    }

    protected static function parse()
    {
        $res = $_SERVER['HTTP_X_'.SESSION_AUTH] ?? $_COOKIE[SESSION_AUTH] ?? null;
        if ($res) {
            return servSession::parseAuth($res);
        } else {
            return false;
        }
    }
}