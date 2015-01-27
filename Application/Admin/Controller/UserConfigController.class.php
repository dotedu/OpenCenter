<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;


use Admin\Builder\AdminConfigBuilder;
/**
 * Class UserConfigController  后台用户配置控制器
 * @package Admin\Controller
 * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
 */
class UserConfigController extends AdminController {

    public function index(){

        $admin_config = new AdminConfigBuilder();
        $data = $admin_config->handleConfig();

        $admin_config->title('用户配置')
           ->keyCheckBox('REG_SWITCH','注册开关','允许使用的注册选项,全不选即为关闭注册',array('username'=>'用户名','email'=>'邮箱','mobile'=>'手机'))
            ->buttonSubmit('', '保存')->data($data);
        $admin_config->display();
    }

}
