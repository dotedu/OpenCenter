<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-3-3
 * Time: 下午3:23
 * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
 */


error_reporting(0);
define('OC_ROOT', substr(__FILE__, 0, -11));


class OCApi{
function oc_post($model,$action,$args=array()){
    global $oc_model;
    if(empty($oc_model[$model])) {
         include_once OC_ROOT."Model/$model.php";
        $oc_model[$model] = new $model();
    }
    $action = 'do'.ucfirst($action);
    return $oc_model[$model]->$action($args);
}

function oc_user_login($username,$password){

    $return = $this->oc_post('User', 'login', array('username'=>$username, 'password'=>$password));
    return $return;
}


function oc_get_user_info($where=''){
    $return ='无法查找';
    if($where){
        $return = $this->oc_post('User', 'getUserInfo', $where);
    }
    return $return;
}


function oc_syn_login($uid){
    $return = $this->oc_post( 'User', 'synLogin', $uid);
    return $return;
}


function oc_syn_logout(){
    $return = $this->oc_post( 'User', 'synLogout', null);
    return $return;
}


}