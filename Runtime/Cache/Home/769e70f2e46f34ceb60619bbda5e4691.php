<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php echo hook('syncMeta');?>

<?php $oneplus_seo_meta = get_seo_meta($vars,$seo); ?>
<?php if($oneplus_seo_meta['title']): ?><title><?php echo ($oneplus_seo_meta['title']); ?></title>
    <?php else: ?>
    <title><?php echo C('WEB_SITE_TITLE');?></title><?php endif; ?>
<?php if($oneplus_seo_meta['keywords']): ?><meta name="keywords" content="<?php echo ($oneplus_seo_meta['keywords']); ?>"/><?php endif; ?>
<?php if($oneplus_seo_meta['description']): ?><meta name="description" content="<?php echo ($oneplus_seo_meta['description']); ?>"/><?php endif; ?>

<!-- zui -->
<link href="/opencenter/Public/zui/css/zui.css" rel="stylesheet">
<link href="/opencenter/Public/css/core.css" rel="stylesheet"/>
<link href="/opencenter/Public/zui/css/zui-theme.css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="/opencenter/Public/js/ext/magnific/magnific-popup.css"/>
<!--<script src="/opencenter/Public/js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="/opencenter/Public/js/com/com.functions.js"></script>

<script type="text/javascript" src="/opencenter/Public/js/core.js"></script>-->
<script src="/opencenter/Public/js.php?f=js/jquery-2.0.3.min.js,js/com/com.functions.js,js/core.js"></script>
<!--Style-->
<!--合并前的js-->
<?php $config = api('Config/lists'); C($config); $icp=C('WEB_SITE_ICP'); $count_code=C('COUNT_CODE'); ?>
<script type="text/javascript">
    var ThinkPHP = window.Think = {
        "ROOT": "/opencenter", //当前网站地址
        "APP": "/opencenter/index.php?s=", //当前项目地址
        "PUBLIC": "/opencenter/Public", //项目公共目录地址
        "DEEP": "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
        "MODEL": ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
        "VAR": ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"],
        'URL_MODEL': "<?php echo C('URL_MODEL');?>",
        'WEIBO_ID': "<?php echo C('SHARE_WEIBO_ID');?>"
    }
</script>

<!-- Bootstrap库 -->
<!--
<?php $js[]=urlencode('/static/bootstrap/js/bootstrap.min.js'); ?>

&lt;!&ndash; 其他库 &ndash;&gt;
<script src="/opencenter/Public/static/qtip/jquery.qtip.js"></script>
<script type="text/javascript" src="/opencenter/Public/Core/js/ext/slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="/opencenter/Public/static/jquery.iframe-transport.js"></script>
-->
<!--CNZZ广告管家，可自行更改-->
<!--<script type='text/javascript' src='http://js.adm.cnzz.net/js/abase.js'></script>-->
<!--CNZZ广告管家，可自行更改end-->
<!-- 自定义js -->
<!--<script src="/opencenter/Public/js.php?get=<?php echo implode(',',$js);?>"></script>-->


<script>
    //全局内容的定义
    var _ROOT_ = "/opencenter";
    var MID = "<?php echo is_login();?>";
    var MODULE_NAME="<?php echo MODULE_NAME; ?>";
    var ACTION_NAME="<?php echo ACTION_NAME; ?>";
</script>

<audio id="music" src="" autoplay="autoplay"></audio>
<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>
</head>
<body>
	<!-- 头部 -->
	<?php if((is_login()) ): ?><div id="right_panel" class="friend_panel visible-md visible-lg" style="display: none;">
        <a class="btn-pull" onclick="show_panel()"> <img style="width: 30px" src="/opencenter/Public/images/friend.png"/> </i>
            <script>
                function show_panel() {
                    var $right_panel = $('#right_panel_main');
                    if ($right_panel.text()) {
                        $right_panel.load(U('Ucenter/Session/panel'));
                        $right_panel.toggle();
                    } else {
                        $right_panel.toggle();
                    }

                }
            </script>

            <i id="friend_has_new"
            <?php $map_mid=is_login(); $modelTP=D('talk_push'); $has_talk_push=$modelTP->where("(uid = ".$map_mid." and status = 1) or (uid = ".$map_mid." and status = 0)")->count(); $has_message_push=D('talk_message_push')->where("uid= ".$map_mid." and (status=1 or status=0)")->count(); if($has_talk_push || $has_message_push){ ?>
            style="display: inline-block"
            <?php } ?>
            ></i>

        </a>
        <?php if(count($currentSession) == 0): ?><div id="right_panel_main" style="display: none;">
                <div style="color: white;line-height: 500px;font-size: 16px;padding:10px;">
                    <img src="/opencenter/Public/images/loading.gif"/>
                </div>
            </div>
            <?php else: ?>
            <div id="right_panel_main" style="display: none;" >
                <div style="color: white;line-height: 500px;font-size: 16px;padding:10px;">
                    <img src="/opencenter/Public/images/loading.gif"/>
                </div>
            </div><?php endif; ?>


    </div>
    <!--开始聊天板-->
    <div id="chat_box" style="display: none" class="chat_panel weibo_post_box">
        <div class="panel_title"><img id="chat_ico" class="chat_avatar avatar-img" src="<?php echo ($friend["avatar64"]); ?>">

            <div id="chat_title" class="title pull-left text-more"></div>
            <div class="control_btns pull-right"><a><i onclick="$('#chat_box').hide();"
                                                       class="icon-minus"></i></a><!-- <a
                ><i class="glyphicon glyphicon-off"></i></a>--></div>
        </div>
        <div class="row talk-body ">
            <div id="scrollArea_chat" class="row ">
                <div id="scrollContainer_chat">
                </div>
            </div>

        </div>

        <div class="send_box">
            <input id="chat_id" type="hidden" value="0">
            <?php $talk_self=query_user(array('avatar128')); ?>
            <script>
                var myhead = "<?php echo ($talk_self["avatar128"]); ?>";
            </script>
            <textarea id="chat_content" class="form-control"></textarea>

        </div>


        <div class="row">
            <div class="col-md-6">
                <button class=" btn btn-danger" onclick="talker.exit()"
                        style="margin: 10px 10px" title="退出聊天"><i class="icon-off"></i>
                </button>
                <!--  <button class=" btn btn-success" onclick="chat_exit()"
                          style="margin: 10px 10px" title="邀请好友"><i class="glyphicon glyphicon-plus"></i>
                  </button>-->
                <a href="javascript:" onclick="insertFace($(this))"><img class="weibo_type_icon" src="/opencenter/Public/static/image/bq.png"/></a>
            </div>
            <div class="col-md-6">

                <button class="pull-right btn btn-primary" onclick="talker.post_message()"
                        style="margin: 10px 10px"> 发送 Ctrl+Enter
                </button>
            </div>
            <div id="emot_content" class="emot_content" style="margin-top: -165px;margin-left: -415px;"></div>


        </div>
    </div>
    <?php else: ?>
    <div id="right_panel" class="friend_panel visible-md visible-lg" style="display: none;">
        <a class="btn-pull" onclick="toast.error('请登陆后使用好友面板。','温馨提示')"> <img style="width: 30px" src="/opencenter/Public/images/friend.png"/>
        </a>
    </div><?php endif; ?>

<?php D('Member')->need_login(); ?>
<!--[if lt IE 8]>
<div class="alert alert-danger" style="margin-bottom: 0">您正在使用 <strong>过时的</strong> 浏览器. 是时候 <a target="_blank"
                                                                                                href="http://browsehappy.com/">更换一个更好的浏览器</a>
    来提升用户体验.
</div>
<![endif]-->

<?php $unreadMessage=D('Common/Message')->getHaventReadMeassageAndToasted(is_login()); ?>
<div id="nav_bar" class="nav_bar">
    <nav class="container navbar-static-top" id="nav_bar_container" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">打开下拉菜单</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php $logo = get_cover(C('SITE_LOGO'),'path'); $logo = $logo?$logo:'/opencenter/Public/images/logo.png'; ?>
            <a class="logo" href="<?php echo U('Home/Index/index');?>"><img src="<?php echo ($logo); ?>"/></a>
        </div>
        <div class="collapse navbar-collapse " id="nav_bar_main">
            <ul class="nav navbar-nav">
                <?php $__NAV__ = M('Channel')->field(true)->where("status=1")->order("sort")->select(); if(is_array($__NAV__)): $i = 0; $__LIST__ = $__NAV__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i; if(($nav["pid"]) == "0"): $children=D('Channel')->where(array('pid'=>$nav['id']))->order('sort asc')->select(); if($children){ ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle nav_item" data-toggle="dropdown" href="#"
                               style="color:<?php echo ($nav["color"]); ?>"><i class="icon-<?php echo ($nav["icon"]); ?>"></i>

                                <?php echo ($nav["title"]); ?> <span class="caret"></span>
                                <?php if(($nav["band_text"]) != ""): ?><span class="label label-badge" style="background: <?php echo ($nav["band_color"]); ?>"><?php echo ($nav["band_text"]); ?></span><?php endif; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if(is_array($children)): $i = 0; $__LIST__ = $children;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$subnav): $mod = ($i % 2 );++$i;?><li role="presentation"><a role="menuitem" tabindex="-1"
                                                               style="color:<?php echo ($subnav["color"]); ?>"
                                                               href="<?php echo (get_nav_url($subnav["url"])); ?>"
                                                               target="<?php if(($subnav["target"]) == "1"): ?>_blank<?php else: ?>_self<?php endif; ?>"><?php echo ($subnav["title"]); ?>
                                        <?php if(($subnav["band_text"]) != ""): ?><span class="badge"
                                                                                    style="background: <?php echo ($subnav["band_color"]); ?>"><?php echo ($subnav["band_text"]); ?></span><?php endif; ?>
                                    </a>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </li>
                        <?php }else{ ?>
                        <li class="<?php if((get_nav_active($nav["url"])) == "1"): ?>active<?php else: endif; ?>">
                            <a href="<?php echo (get_nav_url($nav["url"])); ?>"
                               target="<?php if(($nav["target"]) == "1"): ?>_blank<?php else: ?>_self<?php endif; ?>"
                               style="color:<?php echo ($nav["color"]); ?>"><i class="icon-<?php echo ($nav["icon"]); ?>"></i> <?php echo ($nav["title"]); ?>
                                <?php if(($nav["band_text"]) != ""): ?><span class="label label-badge "
                                                                         style="background: <?php echo ($nav["band_color"]); ?>"><?php echo ($nav["band_text"]); ?></span><?php endif; ?>
                            </a>
                        </li>
                        <?php } endif; endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <!--登陆面板-->
                <?php if(is_login()): ?><li class="dropdown  hidden-xs hidden-sm">
                        <div></div>
                        <a id="nav_info" class="dropdown-toggle text-left" data-toggle="dropdown">
                            <span class="icon-bell-alt"></span> 消息
                            <span id="nav_bandage_count"
                            <?php if(count($unreadMessage) == 0): ?>style="display: none"<?php endif; ?>
                            class="label label-badge label-success"><?php echo count($unreadMessage);?></span>
                            &nbsp;
                        </a>
                        <ul class="dropdown-menu extended notification">
                            <li>
                                <div class="clearfix header">
                                    <div class="col-xs-6 nav_align_left"><span
                                            id="nav_hint_count"><?php echo count($unreadMessage);?></span> 条未读
                                    </div>
                                </div>
                            </li>
                            <li class="info-list">
                                <div class="list-wrap">
                                    <ul id="nav_message" class="dropdown-menu-list scroller  list-data"
                                        style="width: auto;">
                                        <?php if(count($unreadMessage) == 0): ?><div style="font-size: 18px;color: #ccc;font-weight: normal;text-align: center;line-height: 150px">
                                                暂无任何消息!
                                            </div>
                                            <?php else: ?>
                                            <?php if(is_array($unreadMessage)): $i = 0; $__LIST__ = $unreadMessage;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$message): $mod = ($i % 2 );++$i;?><li>
                                                    <a data-url="<?php echo ($message["url"]); ?>"
                                                       onclick="Notify.readMessage(this,<?php echo ($message["id"]); ?>)">
                                                        <i class="icon-bell"></i>
                                                        <?php echo ($message["title"]); ?>
                                            <span class="time">
                                            <?php echo ($message["ctime"]); ?>
                                            </span>
                                                    </a>
                                                </li><?php endforeach; endif; else: echo "" ;endif; endif; ?>

                                    </ul>
                                </div>
                            </li>
                            <li class="footer text-right">
                                <div class="btn-group">
                                    <button onclick="Notify.setAllReaded()" class="btn btn-sm  "><i
                                            class="icon-check"></i> 全部已读
                                    </button>
                                    <a class="btn  btn-sm  " href="<?php echo U('ucenter/Message/message');?>">
                                        查看消息
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a title="修改资料" href="<?php echo U('ucenter/Config/index');?>"><i
                                class="icon-cog"></i> 设置</a>
                    </li>
                    <li class="top_spliter hidden-xs"></li>
                    <li class="dropdown">
                        <?php $common_header_user = query_user(array('nickname')); ?>
                        <a role="button" class="dropdown-toggle dropdown-toggle-avatar" data-toggle="dropdown">
                            <?php echo ($common_header_user["nickname"]); ?>&nbsp;<i style="font-size: 12px"
                                                                   class="icon-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu text-left" role="menu">
                            <li><a href="<?php echo U('ucenter/Index/index');?>"><span
                                    class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;个人主页</a>
                            </li>
                            <li><a href="<?php echo U('ucenter/message/message');?>"><span
                                    class="glyphicon glyphicon-star"></span>&nbsp;&nbsp;消息中心</a>
                            </li>
                            <li><a href="<?php echo U('ucenter/Collection/index');?>"><span
                                    class="glyphicon glyphicon-star"></span>&nbsp;&nbsp;我的收藏</a>
                            </li>

                            <li><a href="<?php echo U('ucenter/Index/rank');?>"><span
                                    class="glyphicon glyphicon-star"></span>&nbsp;&nbsp;我的头衔</a>
                            </li>
                            <?php echo hook('personalMenus');?>
                            <?php if(is_administrator()): ?><li><a href="<?php echo U('Admin/Index/index');?>" target="_blank"><span
                                        class="glyphicon glyphicon-dashboard"></span>&nbsp;&nbsp;管理后台</a></li><?php endif; ?>
                            <li><a event-node="logout"><span
                                    class="glyphicon glyphicon-off"></span>&nbsp;&nbsp;注销</a>
                            </li>
                        </ul>
                    </li>
                    <li class="top_spliter hidden-xs"></li>
                    <?php else: ?>


                    <li class="top_spliter hidden-xs"></li>
                    <li class="hidden-xs">
                        <?php $open_quick_login=modC('OPEN_QUICK_LOGIN', 0, 'USERCONFIG'); ?>
                        <script>
                            var OPEN_QUICK_LOGIN = "<?php echo ($open_quick_login); ?>";
                        </script>
                        <a data-login="do_login">登录</a>
                    </li>
                    <li class="hidden-xs">
                        <a href="<?php echo U('Ucenter/Member/register');?>">注册</a>
                    </li>
                    <li class="spliter hidden-xs"></li><?php endif; ?>
            </ul>

        </div>

        <!--导航栏菜单项-->

        <div class="row visible-xs">
            <div class="navbar-header col-xs-3 pull-right text-left">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav_bar_main">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button>
            </div>
        </div>
        <!--举报插件钩子-->
        <?php echo hook('report',array('type'=>'home','data'=>数组,'url'=> 'home/index/index.html'));?>
        <!--举报插件钩子-->

    </nav>

</div>


<!--换肤插件钩子-->
<?php echo hook('setSkin');?>
<!--换肤插件钩子 end-->
<a id="goTopBtn"></a>
<?php if(is_login()&&(get_login_role_audit()==2||get_login_role_audit()==0)){ ?>
<div class="alert alert-danger" style="margin-bottom: 0">您当前登录的 <strong>角色</strong>还未通过审核或被禁用。
    <a target="_blank" href="<?php echo U('ucenter/config/role');?>">更换其它角色登录</a>
</div>
<?php } ?>
	<!-- /头部 -->
	
	<!-- 主体 -->
	
<div id="main-container" class="container">
    <div class="row" >
        
    <link type="text/css" rel="stylesheet" href="/opencenter/Application/Home/Static/css/home.css"/>
    <!-- 主体 -->
    <!--顶部Banner-->
    <div class="container common_block_border" style="position: relative">
        <div class="article">
            <div class="row">
                <div class="col-xs-7">
                    <h1>
                        OpenCenter 永久免费开源的用户中心
                    </h1>

                    <p>
                        OpenCenter是一款类似Ucenter的完全开源免费的用户中心系统，系统提供云平台用于功能扩展。OC的魅力在于，使用它，您将大大缩短产品的架构时间，除此之外还有一个庞大的开发者社区为您的产品添钻加瓦。
                    </p>

                    <h2>
                        产品特点
                    </h2>

                    <p>
                    <ol>
                        <li>
                            永久开源免费，不收取任何版权费用且可用于商业，可用于再发布。
                        </li>
                        <li>
                            模块可拆卸，系统只保留核心的功能，其余功能通过扩展模块来实现。
                        </li>
                        <li>内含插件机制，可以方便在不改动系统核心源码的基础上局部扩展功能。</li>

                    </ol>
                    </p>
                    <h2>
                        产品架构
                    </h2>

                    <p>
                        系统基于OneThink进行了一系列的二次开发，OneThink系基于ThinkPhp框架的一款CMF系统。OC开发团队去除了OT中的内容管理部分，提取出核心的用户系统，使其允许在任何类型的网站项目中使用。
                    </p>

                    <h3>
                        以下项目基于OC
                    </h3>

                    <p>


                        <section class="cards">
                            <div class="col-xs-6">
                                <a target="_blank" href="http://www.opensns.cn" class="card">
                                    <img src="/opencenter/Application/Home/Static/images/os.png" alt="">
                                    <strong class="card-heading"><i class="icon-globe"></i> OpenSNS V2</strong>

                                    <div class="card-content text-muted">
                                        一款开源的SNS社交产品，基于OpenCenter开发。包含微博、论坛、群组、专辑、活动、微店、积分商城、分类信息等模块。
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-6">
                                <a target="_blank" href="http://www.opensns.cn" class="card">
                                    <img src="/opencenter/Application/Home/Static/images/no.png" alt="">
                                    <strong class="card-heading">虚位以待</strong>

                                    <div class="card-content text-muted">
                                        欢迎向我们提交您的项目，免费获得广告位。<br/>提交方式：<br/>联系QQ：<i class="icon-qq"></i> 276905621
                                    </div>
                                </a>
                            </div>
                        </section>
                    </p>
                </div>
                <div class="col-xs-4">
                    <h1>相关资料</h1>

                    <h2>学习资料</h2>

                    <div class="row">
                        <div class="col-xs-6">
                            <ul class="list-group">
                                <li class="active list-group-item"><i class="icon-file"></i> <a target="_blank" href="http://www.ocenter.cn/index.php?m=book&f=browse&nodeID=1" style="color: white">OCenter手册 <span class="label label-badge label-danger">在线</span></a>
                                </li>
                                <li class="list-group-item"><i class="icon-file"></i> <a target="_blank"
                                                                                         href="http://document.thinkphp.cn/">ThinkPHP手册</a>
                                </li>
                                <li class="list-group-item"><i class="icon-file"></i> <a target="_blank"
                                                                                         href="http://document.onethink.cn/">OneThink手册</a>
                                </li>

                            </ul>
                        </div>
                        <div class="col-xs-6">

                            <ul class="list-group">
                                <li class="list-group-item"><i class="icon-file"></i> <a target="_blank"
                                                                                         href="http://www.zui.sexy">ZUI手册</a>
                                </li>
                            </ul>

                        </div>

                    </div>


                    </p>
                    <h2>相关网址</h2>

                    <p>
                    <ul class="list-group">

                        <li class="list-group-item active">
                            <i class="icon-link"></i> <a style="color: white" target="_blank"
                                                         href="http://www.ocenter.cn" class="text-ellipsis">OpenCenter产品网站</a>
                        </li>
                        <li class="list-group-item">
                            <i class="icon-link"></i> <a target="_blank" href="http://dev.ocenter.cn"
                                                         class="text-ellipsis">OpenCenter开发者社区</a>
                        </li>
                        <li class="list-group-item">
                            <i class="icon-link"></i> <a target="_blank" href="http://www.opensns.cn"
                                                         class="text-ellipsis">OpenSNS开源社交产品</a>
                        </li>
                    </ul>
                    </p>

                    <h2>相关技术群</h2>
                    <ul class="list-group">
                        <li class="active list-group-item" style="color: white"><i class="icon-qq"></i> OCD 1群 390967955
                            <a class="btn btn-default btn-sm" target="_blank"
                               href="http://jq.qq.com/?_wv=1027&k=ZnlGNd"><i
                                    class="icon-plus-sign"></i> 加群</a></li>
                    </ul>
                    <h2>相关版本库</h2>
                    <ul class="list-group">
                        <li class="active list-group-item " style="color: white;">
                            <a style="color: white" href="http://git.oschina.net/yhtt2020/OpenCenter" target="_blank"><i
                                    class="icon-code-fork"></i> OpenCenter源码库</a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://git.oschina.net/yhtt2020/OpenSNS" target="_blank"><i
                                    class="icon-code-fork"></i> OpenSNS源码库</a>
                        </li>
                    </ul>
                </div>

            </div>
            <script src='http://git.oschina.net/yhtt2020/OpenCenter/widget_preview'></script>

            <style>
                .pro_name a{color: #4d4d4d;}
                .osc_git_title{background-color: #d8e5f1;}
                .osc_git_box{background-color: #fafafa;}
                .osc_git_box{border-color: #ddd;}
                .osc_git_info{color: #666;}
                .osc_git_main a{color: #3d3d3d;}
            </style>
        </div>


        <div class="alert with-icon alert-info">
            <i class="icon-info-sign"></i>

            <div class="content">此页面是默认的演示首页，开发者可自行删除。</div>
        </div>
    </div>



    </div>
</div>

<script type="text/javascript">
    $(function(){
        $(window).resize(function(){
            $("#main-container").css("min-height", $(window).height() - 343);
        }).resize();
    })
</script>
	<!-- /主体 -->

	<!-- 底部 -->
	<div class="footer-jumbotron footer_bar hide">
    <div class="container">
        <div class="row">
            <?php if(!empty($icp)): ?><div class="col-xs-6">备案号：<a href="http://www.miitbeian.gov.cn/" target="_blank">
                    <?php echo C('WEB_SITE_ICP');?></a>
                </div><?php endif; ?>
            <div class="col-md-12">
                <?php echo ($count_code); ?>
            </div>
        </div>
    </div>

</div>
</div>
</div>
<div>
    <?php echo C('COUNT_CODE');?>
</div>
<!-- jQuery (ZUI中的Javascript组件依赖于jQuery) -->


<!-- 为了让html5shiv生效，请将所有的CSS都添加到此处 -->
<link type="text/css" rel="stylesheet" href="/opencenter/Public/static/qtip/jquery.qtip.css"/>



<!--<script type="text/javascript" src="/opencenter/Public/js/com/com.notify.class.js"></script>-->

<!-- 其他库-->
<!--<script src="/opencenter/Public/static/qtip/jquery.qtip.js"></script>
<script type="text/javascript" src="/opencenter/Public/js/ext/slimscroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="/opencenter/Public/static/jquery.iframe-transport.js"></script>

<script type="text/javascript" src="/opencenter/Public/js/ext/magnific/jquery.magnific-popup.min.js"></script>-->
<!--CNZZ广告管家，可自行更改-->
<!--<script type='text/javascript' src='http://js.adm.cnzz.net/js/abase.js'></script>-->
<!--CNZZ广告管家，可自行更改end
 自定义js-->

<!--<script type="text/javascript" src="/opencenter/Public/js/ext/placeholder/placeholder.js"></script>
<script type="text/javascript" src="/opencenter/Public/js/ext/atwho/atwho.js"></script>
<script type="text/javascript" src="/opencenter/Public/zui/js/zui.js"></script>-->
<link type="text/css" rel="stylesheet" href="/opencenter/Public/js/ext/atwho/atwho.css"/>

<script src="/opencenter/Public/js.php?t=js&f=js/com/com.notify.class.js,static/qtip/jquery.qtip.js,js/ext/slimscroll/jquery.slimscroll.min.js,js/ext/magnific/jquery.magnific-popup.min.js,js/ext/placeholder/placeholder.js,js/ext/atwho/atwho.js,zui/js/zui.js&v=<?php echo ($site["sys_version"]); ?>.js"></script>
<script type="text/javascript" src="/opencenter/Public/static/jquery.iframe-transport.js"></script>


<script type="text/javascript" charset="utf-8" src="/opencenter/Public/static/ueditor/third-party/SyntaxHighlighter/shCore.js"></script>
<link rel="stylesheet" type="text/css" href="/opencenter/Public/static/ueditor/third-party/SyntaxHighlighter/shCoreDefault.css"/>
<script type="text/javascript">
    SyntaxHighlighter.all();
</script>
<!--优化系统DUMP显示方式@mingyangliu-->
<script type="text/javascript">
if ( $("pre").length > 0 ) { 
document.writeln("<div id=\"mydump\"  style=\"position: fixed;z-index: 999;height:400px;top:0;width: 500px;OVERFLOW:auto;\" ></div>");
$("pre").appendTo('#mydump'); 
document.writeln("<div style=\"z-index:9999;height:30px;float:right;text-align: right;overflow:hidden;position:fixed;bottom:0;right:150px;color:#000;line-height:30px;cursor:pointer;\">");
document.writeln("<a style=\"background-color: rgb(255, 255, 255);float: right;\"href=JavaScript:; class=\"STYLE1\" onclick=\"document.all.mydump.style.display=`none`;\">[隐藏DUMP数据]</a>");
document.writeln("<a style=\"background-color: rgb(255, 255, 255);float: right;\"href=JavaScript:; class=\"STYLE1\" onclick=\"document.all.mydump.style.display=`block`;\">[显示DUMP数据]</a>");
document.writeln("</div>");
}
</script>

<!-- 用于加载js代码 -->

<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
    
</div>

	<!-- /底部 -->
</body>
</html>