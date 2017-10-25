<?php


namespace Admin\cli;


use Core\unitDoAction;

class ctrl_ extends \Admin\ctrl_
{
    use unitDoAction;

    public function runBefore(): bool
    {
        if (BOOT_MODE !== BOOT_MODE_CLI) {
            \coreException::halt('Access denied!');
            return false;
        } else {
            return true;
        }
    }
}