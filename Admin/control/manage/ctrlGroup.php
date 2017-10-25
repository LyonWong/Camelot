<?php


namespace Admin\manage;


class ctrlGroup extends ctrl_
{
    public function _DO_()
    {
        \view::tpl('page-go', [
            'page' => '_'
        ])->with('info', 'building...');
    }

}