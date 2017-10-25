<?php


namespace Admin\manage;


class ctrlUser extends ctrl_
{
    public function _DO_()
    {
        \view::tpl('page-go', [
            'page' => '_'
        ])->with('info', 'building...');
    }

}