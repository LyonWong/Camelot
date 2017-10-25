<div class="form-group">
    <div class="input-inline ">
        <div class="input-group">
            <span class="input-group-addon"><?=$this->prefix?></span>
            <select class="form-control input-field" name="<?=$this->name?>">
                <?php var_dump($this->value)?>
                <?=\Admin\wdgtForm::options($this->options, $this->value)?>
            </select>
        </div>
    </div>
</div>
