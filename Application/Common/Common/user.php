<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-1-23
 * Time: 上午11:26
 * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
 */


/**
 * check_username  根据type或用户名来判断注册使用的是用户名、邮箱或者手机
 * @param $username
 * @param $email
 * @param $mobile
 * @param int $type
 * @return bool
 * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
 */
function check_username(&$username, &$email, &$mobile, &$type = 0)
{

    if ($type) {
        switch ($type) {
            case 2:
                $email = $username;
                $username = '';
                $mobile = '';
                $type = 2;
                break;
            case 3:
                $mobile = $username;
                $username = '';
                $email = '';
                $type = 3;
                break;
            default :
                $mobile = '';
                $email = '';
                $type = 1;
                break;
        }
    } else {
        $check_email = preg_match("/[a-z0-9_\-\.]+@[a-z0-9]+[_\-]?\.+[a-z]{2,3}/i", $username, $match_email);
        $check_mobile = preg_match("/^(1[3|4|5|8])[0-9]{9}$/", $username, $match_mobile);
        if ($check_email) {
            $email = $username;
            $username = '';
            $mobile = '';
            $type = 2;
        } elseif ($check_mobile) {
            $mobile = $username;
            $username = '';
            $email = '';
            $type = 3;
        } else {
            $mobile = '';
            $email = '';
            $type = 1;
        }
    }
    return true;
}

/**
 * check_reg_type  验证注册格式是否开启
 * @param $type
 * @return bool
 * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
 */
function check_reg_type($type){
    $t[1] = $t['username'] ='username';
    $t[2] = $t['email'] ='email';
    $t[3] = $t['mobile'] ='mobile';

    $switch = modC('REG_SWITCH','','USERCONFIG');
    if($switch){
        $switch = explode(',',$switch);
        if(in_array($t[$type],$switch)){
           return true;
        }
    }
    return false;

}


function get_next_step($now_step =''){
    $step = modC('REG_STEP', '', 'USERCONFIG');
    $step = explode(',',$step);
    if(empty($now_step) || $now_step == 'start'){
        $return = $step[0];
    }else{
        $now_key = array_search($now_step,$step);
        $return = $step[$now_key+1];
    }
    if(!in_array($return,A('Ucenter/RegStep','Widget')->step) || empty($return)){
        $return = 'finish';
    }
    return $return;
}