<?php $this->tpl('/header')?>
<?= view::css([
    'resource/metronic/admin' => [
        'pages/css/login',
    ]
])?>
<style>
    h3 {font-family: cursive}
    button[type=submit] {margin-left: 5px}
</style>
<title><?=\Admin\wdgtInfo::basic('project')?></title>
<link rel="shortcut icon" href="favicon.ico"/>
