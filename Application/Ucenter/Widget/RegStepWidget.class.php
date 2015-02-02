<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-9
 * Time: 上午8:59
 * @author 郑钟良<zzl@ourstu.com>
 */

namespace Ucenter\Widget;

use Think\Action;

/**
 * Class RegStepWidget  注册步骤
 * @package Usercenter\Widget
 * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
 */
class RegStepWidget extends Action
{

    public $mStep = array(
        'change_avatar'=>'修改头像',
        'account_info'=>'帐号信息',
        'base_info'=>'基本信息',

    );
    public function  view()
    {
        $aStep = I('get.step','','op_t');
        //调用方法输出参数
        if(method_exists($this,$aStep)){
            $this->$aStep();
        }
        $this->display(T('Ucenter@Step/'.$aStep));
    }

    private function change_avatar(){
        $this->assign('user',query_user(array('avatar128')));
    }

    private function account_info(){
        $aStep = I('get.step','','op_t');

    }
} 