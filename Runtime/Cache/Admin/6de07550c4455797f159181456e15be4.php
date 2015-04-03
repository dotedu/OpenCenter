<?php if (!defined('THINK_PATH')) exit();?><!-- 模态框HTML -->
<form class="ajax-form" method="post" action="<?php echo addons_url('Report://Report/addReport');?>">
    <input type="hidden" name="type" value="<?php echo ($param["type"]); ?>">
    <input type="hidden" name="data" value="<?php echo ($param["data"]); ?>">
    <input type="hidden" name="url"  value="<?php echo ($param["url"]); ?>">
    <div style="padding-bottom:45px">
        <span class="col-md-2 pad0" style="font-size: 14px;height: 32px;padding-top: 2px">举报原因：</span>
    <span class="col-md-10 pad0">
        <select data-role="select"  name="reason" class="chosen-select form-control" tabindex="-1">
            <?php if(is_array($reason)): $i = 0; $__LIST__ = $reason;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vl); ?>"><?php echo ($vl); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select></span>
    </div>
    <div>
        <p><textarea class="form-control "  data-role="textarea" name="content" style="height: 6em;" placeholder="详细说明..."></textarea></p>
    </div>

    <div style="height: 40px;margin-left: 18px;width: 120px ">
    <span>
        <p class="pull-left" style="margin-right: 5px" >
            <input type="submit" data-role="submitreport" value="确定" class="btn btn-primary send_box">
        </p>
    </span>
    <span>
        <p class="pull-left" style="margin-left: 5px;">

            <input type="button" value="取消" class="btn btn-primary send_box" >
        </p>
    </span>
    </div>
</form>