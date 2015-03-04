<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-3-3
 * Time: 下午5:08
 * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
 */

require_once(OC_ROOT.'Lib/Mysql.php');
require_once(OC_ROOT.'Lib/Think.php');
class Base {
    var $_args = array();
    var $db;
    var $AUTH_KEY ;
    var $tablePre ;
    var $think;
    var $session_pre;
    var $appid;
    function __construct() {
        $db_config =  require(OC_ROOT. '../oc_config.php');
        $this->db = new Mysql($db_config['SSO_DB_NAME'],$db_config['SSO_DB_HOST'],$db_config['SSO_DB_USER'],$db_config['SSO_DB_PWD']);

        $this->AUTH_KEY= $db_config['SSO_DATA_AUTH_KEY'];
        $this->tablePre = $db_config['SSO_DB_PREFIX'];
        $this->session_pre = $db_config['OC_SESSION_PRE'];
        $this->appid = $db_config['APP_ID'];
        $this->think = new Think( $this->AUTH_KEY);
    }



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

} 