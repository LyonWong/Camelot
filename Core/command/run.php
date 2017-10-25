<?php
require dirname(__DIR__) . '/../Core/bootstrap.php';


const BOOT_MODE = BOOT_MODE_CLI;

$space = \input::cli('space')->value(true);
boot::init($space);
try {
    boot::run(input::cli(-1)->value());
} catch (coreException $e) {
    list($EID, $code) = coreException::parseCode($e->getCode(), true);
    if ($EID == noteException::EID) {
        echo $e->getMessage().LF;exit;
    }
    echo coreException::makeInfo($e);
}
