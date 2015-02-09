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

use Ucenter\Widget\RegStepWidget;
/**
 * Class UserConfigController  后台用户配置控制器
 * @package Admin\Controller
 * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
 */
class UserConfigController extends AdminController {

    public function index(){

        $admin_config = new AdminConfigBuilder();
        $data = $admin_config->handleConfig();

        $step = A('Ucenter/RegStep','Widget')->mStep;
        $step_str = '';
        foreach($step as $key=>$val){
            $step_str .= $key.'（'.$val.'），';
        }


        $admin_config->title('用户配置')
           ->keyCheckBox('REG_SWITCH','注册开关','允许使用的注册选项,全不选即为关闭注册',array('username'=>'用户名','email'=>'邮箱','mobile'=>'手机'))
            ->keyRadio('EMAIL_VERIFY_TYPE','邮箱验证类型','邮箱验证的类型',array(0=>'注册前发送验证邮件',1=>'注册后发送激活邮件'))

            ->keyText('REG_STEP','注册步骤','注册后需要进行的步骤，根据填写顺序进行，当前可用步骤如下：'.$step_str.'请按顺序填写对应的英文名称，用英文逗号‘,’分隔')

            ->keyEditor('REG_EMAIL_VERIFY','邮箱验证模版','用于进行邮箱的验证')
            ->keyEditor('REG_EMAIL_ACTIVATE','邮箱激活模版','用于进行用户的激活')

            ->keyText('SMS_HTTP','短信平台HTTP','短信平台HTTP')
            ->keyText('SMS_UID','短信平台帐号','短信平台帐号')
            ->keyText('SMS_PWD','短信平台密码','短信平台密码')
            ->keyTextArea('SMS_CONTENT','短信内容','短信内容')


            ->group('基础配置','REG_SWITCH,EMAIL_VERIFY_TYPE,REG_STEP')
            ->group('邮箱验证模版','REG_EMAIL_VERIFY')
            ->group('邮箱激活模版','REG_EMAIL_ACTIVATE')
            ->group('短信配置','SMS_HTTP,SMS_UID,SMS_PWD,SMS_CONTENT')

            ->buttonSubmit('', '保存')->data($data);
        $admin_config->display();
    }

}
