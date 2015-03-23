<?php
/**
 * 邀请注册
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-3-23
 * Time: 下午2:52
 * @author 郑钟良<zzl@ourstu.com>
 */

namespace Admin\Controller;


use Admin\Builder\AdminListBuilder;

class InviteController extends AdminController
{

    public function index()
    {
        $builder=new AdminListBuilder();
        $builder->success();
        $builder->display();
    }

} 