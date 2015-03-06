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


class OCApi
{
    /**
     * oc_post  执行方法
     * @param $model
     * @param $action
     * @param array $args
     * @return mixed
     * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
     */
    function oc_post($model, $action, $args = array())
    {
        global $oc_model;
        if (empty($oc_model[$model])) {
            include_once OC_ROOT . "Model/$model.php";
            $oc_model[$model] = new $model();
        }
        $action = 'do' . ucfirst($action);
        return $oc_model[$model]->$action($args);
    }

    /**
     * oc_user_login  登录
     * @param $username
     * @param $password
     * @return mixed
     * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
     */
    function oc_user_login($username, $password)
    {

        $return = $this->oc_post('User', 'login', array('username' => $username, 'password' => $password));
        return $return;
    }

    /**
     * oc_get_user_info 获取用户信息
     * @param string $where
     * @return mixed|string
     * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
     */
    function oc_get_user_info($where = '')
    {
        $return = '无法查找';
        if ($where) {
            $return = $this->oc_post('User', 'getUserInfo', $where);
        }
        return $return;
    }

    /**
     * oc_syn_login  同步登录
     * @param $uid
     * @return mixed
     * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
     */
    function oc_syn_login($uid)
    {
        $return = $this->oc_post('User', 'synLogin', $uid);
        return $return;
    }

    /**
     * oc_syn_logout 同步登出
     * @return mixed
     * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
     */
    function oc_syn_logout()
    {
        $return = $this->oc_post('User', 'synLogout', null);
        return $return;
    }

}