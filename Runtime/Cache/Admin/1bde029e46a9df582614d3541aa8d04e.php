<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>|OpenCenter管理后台</title>
    <link href="/opencenter/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">


    <!--zui-->
    <link rel="stylesheet" type="text/css" href="/opencenter/Application/Admin/Static/zui/css/zui.css" media="all">
    <link rel="stylesheet" type="text/css" href="/opencenter/Application/Admin/Static/css/admin.css" media="all">
    <link rel="stylesheet" type="text/css" href="/opencenter/Application/Admin/Static/css/ext.css" media="all">
    <!--zui end-->

    <!--
        <link rel="stylesheet" type="text/css" href="/opencenter/Application/Admin/Static/css/base.css" media="all">
        <link rel="stylesheet" type="text/css" href="/opencenter/Application/Admin/Static/css/common.css" media="all"-->
    <link rel="stylesheet" type="text/css" href="/opencenter/Application/Admin/Static/css/module.css">
    <link rel="stylesheet" type="text/css" href="/opencenter/Application/Admin/Static/css/style.css" media="all">
    <!--<link rel="stylesheet" type="text/css" href="/opencenter/Application/Admin/Static/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">-->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/opencenter/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/opencenter/Public/js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/opencenter/Application/Admin/Static/js/jquery.mousewheel.js"></script>
    <!--<![endif]-->
    
    <script type="text/javascript">
        var ThinkPHP = window.Think = {
            "ROOT": "/opencenter", //当前网站地址
            "APP": "/opencenter/index.php?s=", //当前项目地址
            "PUBLIC": "/opencenter/Public", //项目公共目录地址
            "DEEP": "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL": ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR": ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"],
            'URL_MODEL': "<?php echo C('URL_MODEL');?>"
        }
    </script>
</head>
<body>
<style>

</style>
<div class="panel-header">
    <nav class="navbar navbar-inverse admin-bar" role="navigation">
        <div class="navbar-header">
            <a href="<?php echo U('Index/index');?>" class="navbar-brand">
                <img class="logo" src="/opencenter/Application/Admin/Static/images/logo.png">
                Open Center</a>
            <!--<a class="navbar-brand" href="<?php echo U('Index/index');?>">OpenCenter 管理后台</a>-->
        </div>
        <div class="collapse navbar-collapse navbar-collapse-example">
            <ul id="nav_bar" class="nav navbar-nav">
                <?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i; if(($menu["hide"]) != "1"): ?><li data-id="<?php echo ($menu["id"]); ?>" class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (u($menu["url"])); ?>">
                            <?php if(($menu["icon"]) != ""): ?><i class="icon-<?php echo ($menu["icon"]); ?>"></i>&nbsp;<?php endif; ?>
                            <?php echo ($menu["title"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="javascript:;"  onclick="clear_cache()"><i class="icon-trash"></i> 清空缓存</a></li>
                <li><a target="_blank" href="<?php echo U('Home/Index/index');?>"><i class="icon-copy"></i> 打开前台</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i>
                        <?php echo session('user_auth.username');?> <b
                                class="caret"></b></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
                        <li><a href="<?php echo U('User/updateNickname');?>">修改昵称</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo U('Public/logout');?>">退出</a></li>
                    </ul>
                </li>
                <script>
                    function clear_cache() {
                        var msg = new $.Messager('清理缓存成功。', {placement: 'bottom'});
                        $.get('/cc.php');
                        msg.show()
                    }
                </script>
            </ul>
        </div>
    </nav>

    <div class="admin-title">

    </div>

</div>
<div class="panel-menu">
    <ul class="nav nav-primary nav-stacked">

        <?php if(is_array($__MODULE_MENU__)): $i = 0; $__LIST__ = $__MODULE_MENU__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if(($v["is_setup"]) == "1"): ?><li>
                    <a  href="<?php echo U($v['admin_entry']);?>" title="<?php echo (text($v["alias"])); ?>" class="text-ellipsis text-center">
                        <i class="icon-<?php echo ($v['icon']); ?>"></i><br/><?php echo ($v["alias"]); ?>
                    </a>
                </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>

    </ul>
    <ul class="nav nav-primary nav-stacked" style="position: absolute;bottom: 0;width: 100%">
        <li>
            <?php if(($__MANAGE_COULD__) == "1"): ?><a href="<?php echo U('module/lists');?>" class="text-center">
                    <i class="icon-cloud"></i><br/>云市场
                </a><?php endif; ?>

        </li>
    </ul>
</div>


<div class="panel-main" style="float:left;">

    <div class="">


    <div class="clearfix " style="">
        <?php if(!empty($__MENU__["child"])): ?><div class="sub_menu_wrapper" style="background: rgb(245, 246, 247); bottom: -10px;top: 0;position: absolute;width: 180px;overflow: auto">
                <div>
                    <nav id="sub_menu" class="menu" data-toggle="menu">
                        <ul class="nav nav-primary">
                            
                                <!--     <?php if(!empty($_extra_menu)): ?>
                                         <?php echo extra_menu($_extra_menu,$__MENU__); endif; ?>-->
                                <?php if(is_array($__MENU__["child"])): $i = 0; $__LIST__ = $__MENU__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
                                    <?php if(!empty($sub_menu)): ?><li class="show">
                                            <a href="#">
                                                <?php if(!empty($key)): echo ($key); endif; ?>
                                            </a>
                                            <ul class="nav">
                                                <?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                                                        <a href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a>
                                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </ul>
                                        </li><?php endif; ?>
                                    <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>

                            

                        </ul>
                    </nav>
                </div>
            </div><?php endif; ?>


        <?php if(!empty($__MENU__["child"])): $col=10; ?>
            <?php else: ?>
            <?php $col=12; endif; ?>
        <div id="main-content" class="" style="padding:10px;padding-left:0;padding-bottom:10px;left: 180px;position:absolute;right: 0;bottom: 0;top: 0;overflow: auto">
            <div id="top-alert" class="fixed alert alert-error" style="display: none;">
                <button class="close fixed" style="margin-top: 4px;">&times;</button>
                <div class="alert-content">这是内容</div>
            </div>
            <div id="main" style="overflow-y:auto;overflow-x:hidden;">
                
                    <!-- nav -->
                    <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                            <span>您的位置:</span>
                            <?php $i = '1'; ?>
                            <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                                    <?php else: ?>
                                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                                <?php $i = $i+1; endforeach; endif; ?>
                        </div><?php endif; ?>
                    <!-- nav -->
                

                <div class="admin-main-container">
                    
	<script type="text/javascript" src="/opencenter/Public/static/uploadify/jquery.uploadify.min.js"></script>
	<div class="main-title cf">
		<h2>插件配置 [ <?php echo ($data["title"]); ?> ]</h2>
	</div>
    <div class="with-padding">
    <form action="<?php echo U('saveConfig');?>" class="form-horizontal" method="post">
    <?php if(empty($custom_config)): if(is_array($data['config'])): foreach($data['config'] as $o_key=>$form): ?><div class="form-item cf">
    <label class="item-label">
        <?php echo ((isset($form["title"]) && ($form["title"] !== ""))?($form["title"]):''); ?>
        <?php if(isset($form["tip"])): ?><span class="check-tips"><?php echo ($form["tip"]); ?></span><?php endif; ?>
    </label>
    <?php switch($form["type"]): case "text": ?><div class="controls">
            <input type="text" name="config[<?php echo ($o_key); ?>]" class="text input-large" value="<?php echo ($form["value"]); ?>">
        </div><?php break;?>
    <?php case "password": ?><div class="controls">
            <input type="password" name="config[<?php echo ($o_key); ?>]" class="text input-large" value="<?php echo ($form["value"]); ?>">
        </div><?php break;?>
    <?php case "hidden": ?><input type="hidden" name="config[<?php echo ($o_key); ?>]" value="<?php echo ($form["value"]); ?>"><?php break;?>
    <?php case "radio": ?><div class="controls">
            <?php if(is_array($form["options"])): foreach($form["options"] as $opt_k=>$opt): ?><label class="radio-inline">
                    <input type="radio" name="config[<?php echo ($o_key); ?>]" value="<?php echo ($opt_k); ?>" <?php if(($form["value"]) == $opt_k): ?>checked<?php endif; ?>><?php echo ($opt); ?>
                </label><?php endforeach; endif; ?>
        </div><?php break;?>
    <?php case "checkbox": ?><div class="controls">
            <?php if(is_array($form["options"])): foreach($form["options"] as $opt_k=>$opt): ?><label class="checkbox-inline">
                    <?php is_null($form["value"]) && $form["value"] = array(); ?>
                    <input type="checkbox" name="config[<?php echo ($o_key); ?>][]" value="<?php echo ($opt_k); ?>" <?php if(in_array(($opt_k), is_array($form["value"])?$form["value"]:explode(',',$form["value"]))): ?>checked<?php endif; ?>><?php echo ($opt); ?>
                </label><?php endforeach; endif; ?>
        </div><?php break;?>
    <?php case "select": ?><div class="controls">
            <select name="config[<?php echo ($o_key); ?>]">
                <?php if(is_array($form["options"])): foreach($form["options"] as $opt_k=>$opt): ?><option value="<?php echo ($opt_k); ?>" <?php if(($form["value"]) == $opt_k): ?>selected<?php endif; ?>><?php echo ($opt); ?></option><?php endforeach; endif; ?>
            </select>
        </div><?php break;?>
    <?php case "textarea": ?><div class="controls">
            <label class="textarea input-large">
                <textarea name="config[<?php echo ($o_key); ?>]" class="form-control form-text-area-size"><?php echo ($form["value"]); ?></textarea>
            </label>
        </div><?php break;?>
    <?php case "picture_union": ?><div class="controls">
            <input type="file" id="upload_picture_<?php echo ($o_key); ?>">
            <input type="hidden" name="config[<?php echo ($o_key); ?>]" id="cover_id_<?php echo ($o_key); ?>" value="<?php echo ($form["value"]); ?>"/>
            <div class="upload-img-box">
                <?php if(!empty($form['value'])): $mulimages = explode(",", $form["value"]); ?>
                    <?php if(is_array($mulimages)): foreach($mulimages as $key=>$one): ?><div class="upload-pre-item" val="<?php echo ($one); ?>">
                            <img src="<?php echo (get_cover($one,'path')); ?>"  ondblclick="removePicture<?php echo ($o_key); ?>(this)"/>
                        </div><?php endforeach; endif; endif; ?>
            </div>
        </div>
        <script type="text/javascript">
            //上传图片
            /* 初始化上传插件 */
            $("#upload_picture_<?php echo ($o_key); ?>").uploadify({
                "height"          : 30,
                "swf"             : "/opencenter/Public/static/uploadify/uploadify.swf",
                "fileObjName"     : "download",
                "buttonText"      : "上传图片",
                "uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
                "width"           : 120,
                'removeTimeout'   : 1,
                'fileTypeExts'    : '*.jpg; *.png; *.gif;',
                "onUploadSuccess" : uploadPicture<?php echo ($o_key); ?>,
            'onFallback' : function() {
                alert('未检测到兼容版本的Flash.');
            }
            });

            function uploadPicture<?php echo ($o_key); ?>(file, data){
                var data = $.parseJSON(data);
                var src = '';
                if(data.status){
                    src = data.url || '/opencenter' + data.path
                    $("#cover_id_<?php echo ($o_key); ?>").parent().find('.upload-img-box').append(
                            '<div class="upload-pre-item" val="' + data.id + '"><img src="/opencenter' + src + '" ondblclick="removePicture<?php echo ($o_key); ?>(this)"/></div>'
                    );
                    setPictureIds<?php echo ($o_key); ?>();
                } else {
                    updateAlert(data.info);
                    setTimeout(function(){
                        $('#top-alert').find('button').click();
                        $(that).removeClass('disabled').prop('disabled',false);
                    },1500);
                }
            }
            function removePicture<?php echo ($o_key); ?>(o){
                var p = $(o).parent().parent();
                $(o).parent().remove();
                setPictureIds<?php echo ($o_key); ?>();
            }
            function setPictureIds<?php echo ($o_key); ?>(){
                var ids = [];
                $("#cover_id_<?php echo ($o_key); ?>").parent().find('.upload-img-box').find('.upload-pre-item').each(function(){
                    ids.push($(this).attr('val'));
                });
                if(ids.length > 0)
                    $("#cover_id_<?php echo ($o_key); ?>").val(ids.join(','));
                else
                    $("#cover_id_<?php echo ($o_key); ?>").val('');
            }
        </script><?php break;?>
    <?php case "group": ?><ul class="nav nav-secondary">
            <?php if(is_array($form["options"])): $i = 0; $__LIST__ = $form["options"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$li): $mod = ($i % 2 );++$i;?><li data-tab="tab<?php echo ($i); ?>" <?php if(($i) == "1"): ?>class="active"<?php endif; ?>><a data-toggle="tab" href="#tab<?php echo ($i); ?>"><?php echo ($li["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>


        <div class="tab-content with-padding">
            <?php if(is_array($form["options"])): $i = 0; $__LIST__ = $form["options"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tab): $mod = ($i % 2 );++$i;?><div id="tab<?php echo ($i); ?>" class="tab-pane <?php if(($i) == "1"): ?>active<?php endif; ?> tab<?php echo ($i); ?>">
                <?php if(is_array($tab['options'])): foreach($tab['options'] as $o_tab_key=>$tab_form): ?><label class="item-label">
                        <?php echo ((isset($tab_form["title"]) && ($tab_form["title"] !== ""))?($tab_form["title"]):''); ?>
                        <?php if(isset($tab_form["tip"])): ?><span class="check-tips"><?php echo ($tab_form["tip"]); ?></span><?php endif; ?>
                    </label>
                    <div class="controls">
                        <?php switch($tab_form["type"]): case "text": ?><input type="text" name="config[<?php echo ($o_tab_key); ?>]" class="text input-large form-control form-input-width" value="<?php echo ($tab_form["value"]); ?>"><?php break;?>
                            <?php case "password": ?><input type="password" name="config[<?php echo ($o_tab_key); ?>]" class="text input-large form-control form-input-width" value="<?php echo ($tab_form["value"]); ?>"><?php break;?>
                            <?php case "hidden": ?><input type="hidden" name="config[<?php echo ($o_tab_key); ?>]" value="<?php echo ($tab_form["value"]); ?>"><?php break;?>
                            <?php case "radio": if(is_array($tab_form["options"])): foreach($tab_form["options"] as $opt_k=>$opt): ?><label class="radio-inline">
                                        <input type="radio" name="config[<?php echo ($o_tab_key); ?>]" value="<?php echo ($opt_k); ?>" <?php if(($tab_form["value"]) == $opt_k): ?>checked<?php endif; ?>><?php echo ($opt); ?>
                                    </label><?php endforeach; endif; break;?>
                            <?php case "checkbox": if(is_array($tab_form["options"])): foreach($tab_form["options"] as $opt_k=>$opt): ?><label class="checkbox-inline">
                                        <?php is_null($tab_form["value"]) && $tab_form["value"] = array(); ?>
                                        <input type="checkbox" name="config[<?php echo ($o_tab_key); ?>][]" value="<?php echo ($opt_k); ?>" <?php if(in_array(($opt_k), is_array($tab_form["value"])?$tab_form["value"]:explode(',',$tab_form["value"]))): ?>checked<?php endif; ?>><?php echo ($opt); ?>
                                    </label><?php endforeach; endif; break;?>
                            <?php case "select": ?><select name="config[<?php echo ($o_tab_key); ?>]">
                                    <?php if(is_array($tab_form["options"])): foreach($tab_form["options"] as $opt_k=>$opt): ?><option value="<?php echo ($opt_k); ?>" <?php if(($tab_form["value"]) == $opt_k): ?>selected<?php endif; ?>><?php echo ($opt); ?></option><?php endforeach; endif; ?>
                                </select><?php break;?>
                            <?php case "textarea": ?><label class="textarea input-large">
                                    <textarea name="config[<?php echo ($o_tab_key); ?>]" class="form-control form-text-area-size"><?php echo ($tab_form["value"]); ?></textarea>
                                </label><?php break;?>
                            <?php case "picture_union": ?><div class="controls">
                                    <input type="file" id="upload_picture_<?php echo ($o_tab_key); ?>">
                                    <input type="hidden" name="config[<?php echo ($o_tab_key); ?>]" id="cover_id_<?php echo ($o_tab_key); ?>" value="<?php echo ($tab_form["value"]); ?>"/>
                                    <div class="upload-img-box">
                                        <?php if(!empty($tab_form['value'])): $mulimages = explode(",", $tab_form["value"]); ?>
                                            <?php if(is_array($mulimages)): foreach($mulimages as $key=>$one): ?><div class="upload-pre-item" val="<?php echo ($one); ?>">
                                                    <img src="<?php echo (get_cover($one,'path')); ?>"  ondblclick="removePicture<?php echo ($o_tab_key); ?>(this)"/>
                                                </div><?php endforeach; endif; endif; ?>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    //上传图片
                                    /* 初始化上传插件 */
                                    $("#upload_picture_<?php echo ($o_tab_key); ?>").uploadify({
                                        "height"          : 30,
                                        "swf"             : "/opencenter/Public/static/uploadify/uploadify.swf",
                                        "fileObjName"     : "download",
                                        "buttonText"      : "上传图片",
                                        "uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
                                        "width"           : 120,
                                        'removeTimeout'   : 1,
                                        'fileTypeExts'    : '*.jpg; *.png; *.gif;',
                                        "onUploadSuccess" : uploadPicture<?php echo ($o_tab_key); ?>,
                                    'onFallback' : function() {
                                        alert('未检测到兼容版本的Flash.');
                                    }
                                    });

                                    function uploadPicture<?php echo ($o_tab_key); ?>(file, data){
                                        var data = $.parseJSON(data);
                                        var src = '';
                                        if(data.status){
                                            src = data.url || '/opencenter' + data.path
                                            $("#cover_id_<?php echo ($o_tab_key); ?>").parent().find('.upload-img-box').append(
                                                    '<div class="upload-pre-item" val="' + data.id + '"><img src="/opencenter' + src + '" ondblclick="removePicture<?php echo ($o_tab_key); ?>(this)"/></div>'
                                            );
                                            setPictureIds<?php echo ($o_tab_key); ?>();
                                        } else {
                                            updateAlert(data.info);
                                            setTimeout(function(){
                                                $('#top-alert').find('button').click();
                                                $(that).removeClass('disabled').prop('disabled',false);
                                            },1500);
                                        }
                                    }
                                    function removePicture<?php echo ($o_tab_key); ?>(o){
                                        var p = $(o).parent().parent();
                                        $(o).parent().remove();
                                        setPictureIds<?php echo ($o_tab_key); ?>();
                                    }
                                    function setPictureIds<?php echo ($o_tab_key); ?>(){
                                        var ids = [];
                                        $("#cover_id_<?php echo ($o_tab_key); ?>").parent().find('.upload-img-box').find('.upload-pre-item').each(function(){
                                            ids.push($(this).attr('val'));
                                        });
                                        if(ids.length > 0)
                                            $("#cover_id_<?php echo ($o_tab_key); ?>").val(ids.join(','));
                                        else
                                            $("#cover_id_<?php echo ($o_tab_key); ?>").val('');
                                    }
                                </script><?php break; endswitch;?>
                    </div><?php endforeach; endif; ?>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div><?php break; endswitch;?>

    </div><?php endforeach; endif; ?>
    <?php else: ?>
    <?php if(isset($custom_config)): echo ($custom_config); endif; endif; ?>
    <input type="hidden" name="id" value="<?php echo I('id');?>" readonly>
    <button type="submit" class="btn submit-btn ajax-post" target-form="form-horizontal">确 定</button>
    <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
    </form>
    </div>


                </div>

            </div>
        </div>
    </div>
    </div>
</div>



<?php if($report){ ?>
<div  class="report_feedback" title="填写四格体验报告" data-toggle="modal" data-target="#myModal">
    <div class="report_icon" ></div>
    <span class="label label-badge label-danger report_point">1</span>
</div>




<div class="modal fade in" id="myModal" aria-hidden="false"  style="display: none">
    <div class="modal-dialog" >
        <div class="modal-content">
            <form class="report_form"  action="<?php echo U('admin/admin/submitReport');?>" method="post">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
                <h4 class="modal-title">四格体验报告</h4>
            </div>

            <div class="modal-body">

                    <div class="row">
                        <!-- 帖子分类 -->
                        <div class="col-sm-12">
<div>感谢您使用我们的产品，希望您的认真反馈有助于我们改善产品。</div>

                                <label class="item-label">我的更新心情</label>
                            <div>
                                <select name="q1" class="report-select" style="width:400px;">
                                    <option value="0">请选择</option>
                                    <option>开心</option>
                                    <option>悲伤</option>
                                    <option>超有爱</option>
                                    <option>期待</option>
                                </select>
                        </div>

                                <label class="item-label">我选择的最有爱更新</label>
                            <div>
                                <select name="q2" class="report-select" style="width:400px;">
                                    <option value="0">请选择</option>
                                    <?php if(is_array($this_update)): $i = 0; $__LIST__ = $this_update;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$option): $mod = ($i % 2 );++$i;?><option value="<?php echo (htmlspecialchars($option)); ?>"><?php echo (htmlspecialchars($option)); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>

                                <label class="item-label">我选择的最不给力更新
                                </label>
                            <div>
                                <select name="q3" class="report-select" style="width:400px;">
                                    <option value="0">请选择</option>
                                    <?php if(is_array($this_update)): $i = 0; $__LIST__ = $this_update;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$option): $mod = ($i % 2 );++$i;?><option value="<?php echo (htmlspecialchars($option)); ?>"><?php echo (htmlspecialchars($option)); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>


                                <label class="item-label">我选择的期待功能
                                </label>
                            <div>
                                <select name="q4" class="report-select" style="width:400px;">
                                    <option value="0">请选择</option>
                                    <?php if(is_array($future_update)): $i = 0; $__LIST__ = $future_update;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$option): $mod = ($i % 2 );++$i;?><option value="<?php echo (htmlspecialchars($option)); ?>"><?php echo (htmlspecialchars($option)); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                    </div>
                    </div>
            </div>
            <div class="modal-footer">
                <?php if(strval($report['url'])!=''){ ?>
                <a class="pull-left" href="<?php echo ($report['url']); ?>" target="_blank" >查看更新详情</a>
                <?php } ?>
                <button type="submit" class="btn ajax-post" target-form="report_form">确定</button>
            </div>

            </form>
        </div>
    </div>
</div>



<?php } ?>


<script>
    $(function () {
        var config = {
            '.chosen-select'           : {search_contains: true, drop_width: 400,no_results_text:'找不到匹配的选项'},
            '.report-select'           : {search_contains: true, width: '400px',no_results_text:'找不到匹配的选项'}
        };
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }

    });
</script>


<script src="/opencenter/Application/Admin/Static/zui/lib/chosen/chosen.js"></script>
<link href="/opencenter/Application/Admin/Static/zui/lib/chosen/chosen.css" type="text/css" rel="stylesheet">




<!-- 内容区 -->

<!-- /内容区 -->
<script type="text/javascript">
    (function () {
        var ThinkPHP = window.Think = {
            "ROOT": "/opencenter", //当前网站地址
            "APP": "/opencenter/index.php?s=", //当前项目地址
            "PUBLIC": "/opencenter/Public", //项目公共目录地址
            "DEEP": "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL": ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR": ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"],
            'URL_MODEL': "<?php echo C('URL_MODEL');?>"
        }
    })();
</script>
<script type="text/javascript" src="/opencenter/Public/static/think.js"></script>

<!--zui-->
<script type="text/javascript" src="/opencenter/Application/Admin/Static/js/common.js"></script>
<script type="text/javascript" src="/opencenter/Application/Admin/Static/js/com/com.toast.class.js"></script>
<script type="text/javascript" src="/opencenter/Application/Admin/Static/zui/js/zui.js"></script>
<script type="text/javascript" src="/opencenter/Application/Admin/Static/zui/lib/autotrigger/autotrigger.min.js"></script>
<!--zui end-->
<link rel="stylesheet" type="text/css" href="/opencenter/Application/Admin/Static/js/kanban/kanban.css" media="all">
<script type="text/javascript" src="/opencenter/Application/Admin/Static/js/kanban/kanban.js"></script>
<script type="text/javascript">
    +function () {
        var $window = $(window), $subnav = $("#subnav"), url;
        $window.resize(function () {
            $("#main").css("min-height", $window.height() - 130);
        }).resize();


        // 导航栏超出窗口高度后的模拟滚动条
        var sHeight = $(".sidebar").height();
        var subHeight = $(".subnav").height();
        var diff = subHeight - sHeight; //250
        var sub = $(".subnav");
        if (diff > 0) {
            $(window).mousewheel(function (event, delta) {
                if (delta > 0) {
                    if (parseInt(sub.css('marginTop')) > -10) {
                        sub.css('marginTop', '0px');
                    } else {
                        sub.css('marginTop', '+=' + 10);
                    }
                } else {
                    if (parseInt(sub.css('marginTop')) < '-' + (diff - 10)) {
                        sub.css('marginTop', '-' + (diff - 10));
                    } else {
                        sub.css('marginTop', '-=' + 10);
                    }
                }
            });
        }
    }();
    highlight_subnav("<?php echo U('Admin'.'/'.CONTROLLER_NAME.'/'.ACTION_NAME,$_GET);?>")
</script>
<!--优化系统DUMP显示方式@mingyangliu-->
<script type="text/javascript">
if ( $("pre").length > 0 ) { 
document.writeln("<div id=\"mydump\"  style=\"position: fixed;z-index: 999;top:0;height:400px;width: 500px;OVERFLOW:auto;\" ></div>");
$("pre").appendTo('#mydump'); 
document.writeln("<div style=\"z-index:9999;height:30px;float:right;text-align: right;overflow:hidden;position:fixed;bottom:0;right:150px;color:#000;line-height:30px;cursor:pointer;\">");
document.writeln("<a style=\"background-color: rgb(255, 255, 255);float: right;\"href=JavaScript:; class=\"STYLE1\" onclick=\"document.all.mydump.style.display=`none`;\">[隐藏DUMP数据]</a>");
document.writeln("<a style=\"background-color: rgb(255, 255, 255);float: right;\"href=JavaScript:; class=\"STYLE1\" onclick=\"document.all.mydump.style.display=`block`;\">[显示DUMP数据]</a>");
document.writeln("</div>");
}
</script>

<script type="text/javascript" charset="utf-8">
	//导航高亮
	highlight_subnav('<?php echo U('Addons/index');?>');
	if($('ul.tab-nav').length){
		//当有tab时，返回按钮不显示
		$('.btn-return').hide();
	}
	$(function(){
		//支持tab
		showTab();
	})
</script>



</body>
</html>