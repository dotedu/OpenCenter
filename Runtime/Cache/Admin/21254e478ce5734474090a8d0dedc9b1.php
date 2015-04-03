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
                    
	<!-- 标题栏 -->
	<div class="main-title">
		<h2>插件列表</h2>
	</div>
	<div class="with-padding">
		<a href="<?php echo U('create');?>" class="btn">快速创建</a>
	</div>

	<!-- 数据列表 -->
	<div class="data-table with-padding">
		<table class="table table-bordered table-striped ">
			<thead>
				<tr>
					<th>名称</th>
					<th>标识</th>
					<th >描述</th>
					<th width="80px">状态</th>
					<th>作者</th>
					<th width="80px">版本</th>
					<th width="120px">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($_list)): if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td><?php echo ($vo["title"]); ?></td>
					<td><?php echo ($vo["name"]); ?></td>
					<td><?php echo ($vo["description"]); ?></td>
					<td><?php echo ((isset($vo["status_text"]) && ($vo["status_text"] !== ""))?($vo["status_text"]):"未安装"); ?></td>
					<td><a target="_blank" href="<?php echo ((isset($vo["url"]) && ($vo["url"] !== ""))?($vo["url"]):'http://www.ocenter.cn/'); ?>"><?php echo ($vo["author"]); ?></a></td>
					<td><?php echo ($vo["version"]); ?></td>
					<td>
						<?php if(empty($vo["uninstall"])): $class = get_addon_class($vo['name']); if(!class_exists($class)){ $has_config = 0; }else{ $addon = new $class(); $has_config = count($addon->getConfig()); } ?>
							<?php if ($has_config): ?>
								<a href="<?php echo U('config',array('id'=>$vo['id']));?>">设置</a>
							<?php endif ?>
						<?php if ($vo['status'] >=0): ?>
							<?php if(($vo["status"]) == "0"): ?><a class="ajax-get" href="<?php echo U('enable',array('id'=>$vo['id']));?>">启用</a>
							<?php else: ?>
								<a class="ajax-get" href="<?php echo U('disable',array('id'=>$vo['id']));?>">禁用</a><?php endif; ?>
						<?php endif ?>
							
								<a class="ajax-get" href="<?php echo U('uninstall?id='.$vo['id']);?>">卸载</a>
							
						<?php else: ?>
							<a class="ajax-get" href="<?php echo U('install?addon_name='.$vo['name']);?>">安装</a><?php endif; ?>
					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				<?php else: ?>
				<td colspan="7" class="text-center"> aOh! 暂时还没有内容! </td><?php endif; ?>
			</tbody>
		</table>
	</div>
	<!-- 分页 -->
    <div class="with-padding">
        <?php echo ($_page); ?>
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



</body>
</html>