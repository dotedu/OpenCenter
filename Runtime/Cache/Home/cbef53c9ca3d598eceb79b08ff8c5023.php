<?php if (!defined('THINK_PATH')) exit();?><link type="text/css" rel="stylesheet" href="<?php echo getRootUrl();?>Addons/Report/_static/css/report.css"/>

<div>
<a data-type="ajax" data-url="<?php echo addons_url('Report://Report/eject',array('param'=>http_build_query($param)));?>" data-title="举报"  data-toggle="modal" >举报</a>
</div>