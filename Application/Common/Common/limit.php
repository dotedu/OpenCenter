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
    var $info = '';

    function __construct()
    {

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
        $time = time();
        $map['action_list'] = array('like', '%[' . $item['action'] . ']%');
        $map['status'] = 1;
        $limitList = D('ActionLimit')->getList($map);
        !empty($item['action'])  && $item['action_id'] = M('action')->where(array('name' => $item['action']))->getField('id');
        foreach ($limitList as &$val) {
            $ago = get_time_ago($val['time_unit'], 1, $time);
            $item['create_time'] = array('egt', $ago);
            $log = M('action_log')->where($item)->order('create_time desc')->select();
            if (count($log >= $val['frequency'])) {
                $this->state = false;
                $punishes = explode(',', $val['punish']);
                foreach ($punishes as $punish) {
                    if (function_exists($punish)) {
                        $this->$punish();
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