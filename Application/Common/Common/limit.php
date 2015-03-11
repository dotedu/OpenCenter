<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-3-10
 * Time: 下午4:39
 * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
 */


class ActionLimit
{

    var $item = array();
    var $state = true;
    var $url;
    var $info = '';
    var $punish = array(
        array('logout_account', '强制注销账户'),
        array('ban_account', '封停账户'),
        array('ban_ip', '防止该IP注册'),
    );

    function __construct()
    {
        $this->url = '';
        $this->info = '';
        $this->state = true;
    }

    function addCheckItem($action = null, $model = null, $record_id = null, $user_id = null, $ip = false)
    {
        $this->item[] = array('action' => $action, 'model' => $model, 'record_id' => $record_id, 'user_id' => $user_id, 'action_ip' => $ip);
        return $this;
    }

    function check()
    {
        $items = $this->item;
        foreach ($items as &$item) {
            $this->checkOne($item);
        }
        unset($item);
    }

    function checkOne($item)
    {
        $item['action_ip'] = $item['action_ip'] ? get_client_ip(1) : null;
        foreach ($item as $k => $v) {
            if (empty($v)) {
                unset($item[$k]);
            }
        }
        unset($k, $v);
        $time = time();
        $map['action_list'] = array(array('like', '%[' . $item['action'] . ']%'), '', 'or');
        $map['status'] = 1;
        $limitList = D('ActionLimit')->getList($map);
        !empty($item['action']) && $item['action_id'] = M('action')->where(array('name' => $item['action']))->getField('id');
        foreach ($limitList as &$val) {
            $ago = get_time_ago($val['time_unit'], 1, $time);
            $item['create_time'] = array('egt', $ago);
            $log = M('action_log')->where($item)->order('create_time desc')->select();
            if (count($log) >= $val['frequency']) {
                $punishes = explode(',', $val['punish']);
                foreach ($punishes as $punish) {
                    //执行惩罚
                    if (method_exists($this, $punish)) {
                        $this->$punish($item);
                    }
                }
                unset($punish);
                if ($val['if_message']) {
                    D('Message')->sendMessageWithoutCheckSelf($item['user_id'], $val['message_content']);
                }
            }
        }
        unset($val);
    }

    /**
     * logout_account 注销已登录帐号
     * @param $item
     * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
     */
    function logout_account($item)
    {
        D('Member')->logout();
    }

    /**
     * ban_account  封停帐号
     * @param $item
     * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
     */
    function ban_account($item)
    {
        set_user_status($item['user_id'], 0);
    }

    function ban_ip($item)
    {
        $this->state = false;
        $this->info = '频繁注册，请1分钟后再注册';
        $this->url = U('home/index/index');
    }

}


function check_action_limit($action = null, $model = null, $record_id = null, $user_id = null, $ip = false)
{
    $obj = new ActionLimit();
    $obj->checkOne(array('action' => $action, 'model' => $model, 'record_id' => $record_id, 'user_id' => $user_id, 'action_ip' => $ip));

    if (!$obj->state) {
        $return['state'] = $obj->state;
        $return['info'] = $obj->info;
        $return['url'] = $obj->url;
    }
    return $return;
}

function get_time_ago($type = 'second', $some = 1, $time = null)
{
    $time = empty($time) ? time() : $time;
    switch ($type) {
        case 'second':
            $result = $time - $some;
            break;
        case 'minute':
            $result = $time - $some * 60;
            break;
        case 'hour':
            $result = $time - $some * 60 * 60;
            break;
        case 'day':
            $result = strtotime('-' . $some . ' day', $time);
            break;
        case 'week':
            $result = strtotime('-' . ($some * 7) . ' day', $time);
            break;
        case 'month':
            $result = strtotime('-' . $some . ' month', $time);
            break;
        case 'year':
            $result = strtotime('-' . $some . ' year', $time);
            break;
        default:
            $result = $time - $some;
    }
    return $result;
}