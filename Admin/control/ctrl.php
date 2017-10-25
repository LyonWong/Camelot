<?php


namespace Admin;


use Core\unitDoAction;

class ctrl extends ctrlSession
{
    use unitDoAction;

    public function _DO_()
    {
        \view::tpl('page-go', [
            'page' => '_',
        ])->with('info', 'Welcome');
    }

}