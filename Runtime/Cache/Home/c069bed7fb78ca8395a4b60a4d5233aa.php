<?php if (!defined('THINK_PATH')) exit(); if($Skin_CanSet): ?><link type="text/css" rel="stylesheet" href="<?php echo getRootUrl();?>Addons/Skin/_static/css/skin.css"/>
    <div id="skin_block">
        <a class="change_skin" data-type="ajax" data-url="<?php echo addons_url('Skin://Skin/change');?>" data-title="设置默认皮肤：" data-toggle="modal" style="-webkit-transform: none ;transition: none"></a>
        <input type="hidden" id="saveAddonUrl" value="<?php echo addons_url('Skin://Skin/save');?>">
    </div><?php endif; ?>