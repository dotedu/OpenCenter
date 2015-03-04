<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-2-28
 * Time: 下午2:41
 * @author 郑钟良<zzl@ourstu.com>
 */

namespace Addons\Skin\Controller;

use Home\Controller\AddonsController;

require_once(ONETHINK_ADDON_PATH . 'Skin/Common/function.php');

class SkinController extends AddonsController
{
    /**
     * 保存个人换肤设置
     */
    public function save()
    {
        $aSkin = I('post.skin', '', 'op_t');
        $aSet_default = I('post.set_default', 0, 'intval');
        $msg['status'] = 0;
        $UserSkinModel = M('UserSkin');
        $exit = $UserSkinModel->where(array('uid' => is_login()))->count();
        if ($aSet_default) { //设为默认
            if ($exit) { //0为不存在了，1为存在
                $result = $UserSkinModel->where(array('uid' => is_login()))->delete();
            } else {
                $result = 1;
            }
            $msg['defaultSkin']=getAddonConfig();
            $msg['defaultSkin']=$msg['defaultSkin']['defaultSkin'];
        } else {
            if ($aSkin == '' || $aSkin == null) {
                $msg['info'] = "未选择皮肤";
                $this->ajaxReturn($msg);
            }
            $skinConfig['skin'] = $aSkin;
            $map['config'] = json_encode($skinConfig);
            $map['uid'] = is_login();
            if ($exit) {
                $changed = $UserSkinModel->where($map)->count();
                if ($changed) { //0为修改了，1为未修改
                    $result = 1;
                } else {
                    $result = $UserSkinModel->where(array('uid' => is_login()))->setField('config', $map['config']);
                }
            } else {
                $result = $UserSkinModel->add($map);
            }
        }

        if ($result) {
            $msg['status'] = 1;
            $msg['info'] = '设置成功';
        } else {
            $msg['info'] = "设置失败";
        }
        $this->ajaxReturn($msg);
    }

    /**
     * 修改皮肤弹窗
     */
    public function change()
    {
        $skinList=getSkinList();
        $this->assign('skinList',$skinList);
        $this->display(T('Addons://Skin@Skin/change'));
    }
} 