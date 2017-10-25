<?= view::js([
    'resource/metronic/admin' => [
        'pages/scripts' => ['login']
    ]
])?>
<div class="copyright">
    Copyright @<?=\Admin\wdgtInfo::basic('copyright')?>
</div>
<?php $this->tpl('/footer')?>
