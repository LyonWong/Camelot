<?php

require dirname(__DIR__) . '/../Core/bootstrap.php';


const BOOT_MODE = BOOT_MODE_CGI;

boot::init('Core');

try {
    boot::run($_SERVER['REQUEST_URI']);
} catch (coreException $e) {
    list($EID, $code) = coreException::parseCode($e->getCode(), true);
    if ($EID == viewException::EID) {
        header("Status: $code");
    }
    if (BOOT_ENV == BOOT_ENV_DEV) {
        echo $info = coreException::makeInfo($e);
    }
}
