<?php namespace Admin;?>
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="/"><?=wdgtInfo::basic('project')?></a>
            <div class="menu-toggler sidebar-toggler hide">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        <?php $this->tpl('page-topmenu')?>
    </div>
</div>

<script type="text/javascript">
    Cookie.prefix = '<?=\config::load('boot', 'public', 'cookie.prefix', '_')?>';
</script>
