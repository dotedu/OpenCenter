<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-3-2
 * Time: 上午10:54
 * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
 */


error_reporting(0);
set_magic_quotes_runtime(0);
$db_config =  require( './oc_config.php');

require_once('./ocenter/Lib/Think.php');

if($db_config['SSO_SWITCH'] ==0){
    exit('该应用未开启单点登录');
}
$think = new think($db_config['SSO_DATA_AUTH_KEY']);
$code = @$_GET['code'];
parse_str($think->think_decrypt($code), $get);

if(in_array($get['action'], array('test','synLogin', 'synLogout'))) {
    $node = new oc_node();
    exit($node->$get['action']($get));
} else {
    exit('error');
}



class oc_node{
    var $db;
    var $tablePre ;
    var $dirpath ;
    var $thisConfig ;
    function oc_node(){
        $this->dirpath = substr(dirname(__FILE__), 0, -5);
        require_once( $this->dirpath.'OcApi/OCenter/Lib/mysql.php');
        $db_config =  require('./oc_config.php');
        $this->db = new mysql($db_config['SSO_DB_NAME'],$db_config['SSO_DB_HOST'],$db_config['SSO_DB_USER'],$db_config['SSO_DB_PWD'],$db_config['SSO_DB_PORT']);
        $this->tablePre = $db_config['SSO_DB_PREFIX'];

        $this->thisConfig = require_once $this->dirpath.'/Conf/common.php';
    }

    function test() {
        return 'success';
    }


    function synLogin($get) {
        $uid = $get['uid'];
        header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
        session_start();

        require_once  $this->dirpath.'OcApi/OCenter/ocenter.php';
        $user = oc_get_user_info('uid='.$uid);

        $auth = array(
            'uid' => $user['uid'],
            'username' => $user['username'],
            'last_login_time' => $user['last_login_time'],
        );

        $_SESSION[$this->thisConfig['SESSION_PREFIX']]['user_auth']=$auth;
        $_SESSION[$this->thisConfig['SESSION_PREFIX']]['user_auth_sign']=data_auth_sign($auth);

    }

    function synLogout($get) {
        header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
        session_start();
        $_SESSION[$this->thisConfig['SESSION_PREFIX']]['user_auth']=null;
        $_SESSION[$this->thisConfig['SESSION_PREFIX']]['user_auth_sign']=null;
    }

}

function data_auth_sign($data)
{
    //数据类型检测
    if (!is_array($data)) {
        $data = (array)$data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}