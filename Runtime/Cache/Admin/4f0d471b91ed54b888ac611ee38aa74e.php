<?php if (!defined('THINK_PATH')) exit();?><link type="text/css" rel="stylesheet" href="<?php echo getRootUrl();?>Addons/Skin/_static/css/skin.css"/>
<div>
    <dl class="lineD">
        <dt>设置默认皮肤：</dt>
        <dd id="style_list">
            <div class="SkinPreview" data-role="SkinPreview">
                <?php if(is_array($data["config"]["defaultSkin"]["options"])): $i = 0; $__LIST__ = $data["config"]["defaultSkin"]["options"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$skin): $mod = ($i % 2 );++$i; if(($skin["value"]) == $data["config"]["defaultSkin"]["value"]): ?><div class="colorBox current" onclick="fChange('<?php echo ($skin["value"]); ?>',$(this));"
                             data-role="colorBox">
                            <a href="javascript:;" onclick="fChange('<?php echo ($skin["value"]); ?>',$(this));">
                                <img src="<?php echo ($skin["thumb_url"]); ?>"/>
                                <div class="skin_title" data-role="skin_title"><span><?php echo ($skin["name"]); ?></span></div>
                            </a>
                        </div>
                        <?php else: ?>
                        <div class="colorBox" onclick="fChange('<?php echo ($skin["value"]); ?>',$(this));" data-role="colorBox">
                            <a href="javascript:;" onclick="fChange('<?php echo ($skin["value"]); ?>',$(this));">
                                <img src="<?php echo ($skin["thumb_url"]); ?>"/>
                                <div class="skin_title" data-role="skin_title"><span><?php echo ($skin["name"]); ?></span></div>
                            </a>
                        </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </dd>
    </dl>
    <input type="hidden" value="<?php echo ($data["config"]["defaultSkin"]["value"]); ?>" name="config[defaultSkin]" id="default"/>
    <dl class="lineD">
        <dt>优先执行默认皮肤：</dt>
        <dd><label><input type="radio" name="config[mandatory]" value="1"
            <?php if(($data["config"]["mandatory"]["value"]) == "1"): ?>checked=checked<?php endif; ?>
            >是 &nbsp;&nbsp;&nbsp;&nbsp;</label><label><input type="radio" name="config[mandatory]" value="0"
            <?php if(($data["config"]["mandatory"]["value"]) == "0"): ?>checked=checked<?php endif; ?>
            >否</label> <br/>

            <p>默认不开启，开启后优先执行默认皮肤，即管理员设置的皮肤。</p>
        </dd>
    </dl>
    <dl class="lineD">
        <dt>用户是否可以设置皮肤：</dt>
        <dd><label><input type="radio" name="config[canSet]" value="1"
            <?php if(($data["config"]["canSet"]["value"]) == "1"): ?>checked=checked<?php endif; ?>
            >是</label> &nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="config[canSet]" value="0"
            <?php if(($data["config"]["canSet"]["value"]) == "0"): ?>checked=checked<?php endif; ?>
            >否</label> <br/>

            <p>默认可以设置，即用户可换肤。</p>
        </dd>
    </dl>
    <dl class="lineD" style="display: hidden;">
        <dd><input type="hidden" name="config[addons_cache]" value="SKIN_ADDON_CONFIG"/></dd>
    </dl>

</div>
<script type="text/javascript">
    /**
     * 改变选中样式
     * @param string key 选中样式Key值
     * @param object this 点击按钮对象
     * @return void
     */
    var fChange = function (key, obj) {
        $('#style_list').find('[data-role="colorBox"]').removeClass('current');
        $(obj).addClass('current');
        $('#default').val(key);
        return false;
    }
    $(function(){
        $('[data-role="SkinPreview"]').find('[data-role="colorBox"]').mouseenter(function(){
            $(this).find('[data-role="skin_title"]').animate({bottom:'0px'});
        }).mouseleave(function(){
                    $(this).find('[data-role="skin_title"]').animate({bottom:'-27px'});
        });
    })
</script>