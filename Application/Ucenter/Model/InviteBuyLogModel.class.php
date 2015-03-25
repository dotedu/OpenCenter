<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-3-25
 * Time: 下午5:23
 * @author 郑钟良<zzl@ourstu.com>
 */

namespace Ucenter\Model;


use Think\Model;

class InviteBuyLogModel extends Model
{
    public function buy($type_id = 0, $num = 0)
    {
        $invite_type=D('Ucenter/InviteType')->where(array('id'=>$type_id))->find();
        $user=query_user('nickname');
        $data['content']="{$user} 在 ".time().' 时购买了 '.$num.' 个 '.$invite_type['title'].' 的邀请名额';

        $data['uid']=is_login();
        $data['invite_type']=$type_id;
        $data['num']=$num;
        $data['create_time']=time();

        $result=$this->add($data);
        return $result;
    }
} 