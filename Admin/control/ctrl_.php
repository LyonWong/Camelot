<?php


namespace Admin;


class ctrl_
{
    /**
     * Resource Identifier
     * @var
     */
    public $_URI_;

    /**
     * controller path
     * @var
     */
    public $_WAY_;

    /**
     * extension type
     * @var
     */
    public $_EXT_;

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function runBefore():bool
    {
        return true;
    }

    public function runBehind():bool
    {
        return true;
    }

}