<?php


namespace Core;


class ctrlCheck extends ctrl_
{
    use unitDoAction;

    public function _DO_()
    {
        \view::tpl('page-go', [
            'page' => 'check',
            'domain' => \config::load('boot', 'public', 'domain'),
        ])
            ->with('mysql', servCheck::mysql())
            ->with('redis', servCheck::redis())
        ;
    }

    public function _DO_raw()
    {
         $raw = [
            'mysql' => servCheck::mysql(),
            'redis' => servCheck::redis()
        ];
         print_r($raw);
    }


}