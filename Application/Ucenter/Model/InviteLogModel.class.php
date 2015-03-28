<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-3-27
 * Time: 下午4:45
 * @author 郑钟良<zzl@ourstu.com>
 */

namespace Ucenter\Model;


use Think\Model;

class InviteLogModel extends Model
{

    public function addData($data=array(),$role=0)
    {
        $inviter_user=query_user('nickname',$data['inviter_id']);
        $user=query_user('nickname',$data['uid']);
        $role=D('Role')->where(array('id'=>$role))->find();
        $data['content']="{$user} 接受了 {$inviter_user} 的邀请，注册了 {$role['title']} 身份。";
        $data['create_time']=time();

        $result=$this->add($data);
        return $result;
    }

} 