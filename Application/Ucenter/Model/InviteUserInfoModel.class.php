<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-3-25
 * Time: 下午6:55
 * @author 郑钟良<zzl@ourstu.com>
 */

namespace Ucenter\Model;


use Think\Model;

class InviteUserInfoModel extends Model
{

    public function addNum($type_id=0,$num=0)
    {
        $map['uid']=is_login();
        $map['invite_type']=$type_id;
        if($this->where($map)->count()){
            $res=$this->where($map)->setInc('num',$num);
        }else{
            $data['uid']=is_login();
            $data['invite_type']=$type_id;
            $data['num']=$num;
            $data['already_num']=0;
            $data['success_num']=0;
            $res=$this->add($data);
        }
        return $res;
    }

    public function decNum($type_id=0,$num=0){
        $map['uid']=is_login();
        $map['invite_type']=$type_id;
        $res=$this->where($map)->setDec('num',$num);//减少可邀请数目
        $this->where($map)->setInc('already_num',$num);//增加已邀请数目
        return $res;
    }

    public function getInfo($map='')
    {
        $data=$this->where($map)->find();
        return $data;
    }

} 