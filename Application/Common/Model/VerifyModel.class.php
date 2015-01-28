<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-1-26
 * Time: 下午4:29
 * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
 */

namespace Common\Model;

use Think\Model;

class VerifyModel extends Model
{
    protected $tableName = 'verify';
    protected $_auto = array(array('create_time', NOW_TIME, self::MODEL_INSERT));



    public function addVerify($account,$type)
    {

        if ($type == 'mobile') {
            $verify = create_rand(6, 'num');
        } else {
            $verify = create_rand(32);
        }
        $this->where(array('account'=>$account,'type'=>$type))->delete();
        $data['verify'] = $verify;
        $data['account'] = $account;
        $data['type'] = $type;
        $data['uid'] = is_login();
        $data = $this->create($data);
        $res = $this->add($data);
        if(!$res){
            return false;
        }
        return $verify;
    }

    public function getVerify($id){
        $verify = $this->where(array('id'=>$id))->getField('verify');
        return $verify;
    }
    public function checkVerify($account,$type,$verify,$uid){
        $verify = $this->where(array('account'=>$account,'type'=>$type,'verify'=>$verify,'uid'=>$uid))->find();
        if(!$verify){
            return false;
        }
        $this->where(array('account'=>$account,'type'=>$type))->delete();
        //$this->where('create_time <= '.get_some_day(1))->delete();

        return true;
    }

}















