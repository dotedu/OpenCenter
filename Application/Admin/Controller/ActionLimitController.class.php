<?php

namespace Admin\Controller;


use Admin\Builder\AdminConfigBuilder;
use Admin\Builder\AdminListBuilder;

/**
 * Class ActionLimitController  后台行为限制控制器
 * @package Admin\Controller
 * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
 */
class ActionLimitController extends AdminController
{

    public function ssoSetting()
    {

        $admin_config = new AdminConfigBuilder();
         $data = $admin_config->handleConfig();

        $admin_config->title('单点登录配置')
            ->keyRadio('SSO_SWITCH_USER_CENTER', '单点登录开关', '作为用户中心的单点登录开关，其他开关在登录配置里面设置', array(0 => '关闭单点登录', 1 => '作为用户中心开启单点登录'))
            ->keyTextArea('SSO_CONFIG', '单点登录配置', '单点登录配置文件中的配置（当开关为开启单点登录时有效，不包括作为用户中心开启单点登录）')
            ->keyLabel('SSO_UC_AUTH_KEY', '用户中心加密密钥', '系统已自动写入配置文件，如写入失败请手动复制。')
            ->keyLabel('SSO_UC_DB_DSN', '用户中心数据连接', '系统已自动写入配置文件，如写入失败请手动复制。')
            ->keyLabel('SSO_UC_TABLE_PREFIX', '用户中心表前缀', '系统已自动写入配置文件，如写入失败请手动复制。')

        ->group('作为用户中心配置','SSO_SWITCH_USER_CENTER')
        ->group('作为应用配置','SSO_CONFIG,SSO_UC_AUTH_KEY,SSO_UC_DB_DSN,SSO_UC_TABLE_PREFIX')
            ->buttonSubmit('', '保存')->data($data);
        $admin_config->display();
    }





    public function limitList()
    {
        //读取规则列表
        $map = array('status' => array('EGT', 0));
        $model = M('action_limit');
        $List = $model->where($map)->order('id asc')->select();

        //显示页面
        $builder = new AdminListBuilder();
        $builder->title('行为限制列表')
            ->buttonNew(U('editLimit'))
            ->setStatusUrl(U('setLimitStatus'))->buttonEnable()->buttonDisable()->buttonDelete()
            ->keyId()
            ->keyTitle()
            ->keyText('frequency', '频率')
            ->keyText('punish', '处罚')
            ->keyBool('if_message', '是否发送提醒')
            ->keyText('message_content', '处罚')
            ->keyText('action_list', '行为')
            ->keyStatus()

            ->keyDoActionEdit('editLimit?id=###')
            ->data($List)
            ->display();
    }

    public function editLimit()
    {
        $aId = I('id', 0, 'intval');
        $model = D('ActionLimit');
        if (IS_POST) {

            $data['title'] = I('post.title', '', 'op_t');
            $data['frequency'] = I('post.frequency', 1, 'intval');
            $data['punish'] = I('post.punish', '', 'op_t');
            $data['if_message'] = I('post.if_message', '', 'op_t');
            $data['message_content'] = I('post.message_content', '', 'op_t');
            $data['action_list'] = I('post.action_list', '', 'op_t');
            $data['status'] = I('post.status', 1, 'intval');

            $data['punish'] = implode(',',$data['punish']);
            $data['action_list'] = implode(',',$data['action_list']);
            if ($aId != 0) {
                $data['id'] = $aId;
                $res = $model->editActionLimit($data);
            } else {
                $res = $model->addActionLimit($data);
            }
            $this->success(($aId == 0 ? '添加' : '编辑') . '成功', $aId == 0 ? U('', array('id' => $res)) : '');

        } else {
            $builder = new AdminConfigBuilder();
            if ($aId != 0) {
                $limit = $model->getActionLimit(array('id' => $aId));
                $limit['punish'] = explode(',',$limit['punish']);
                $limit['action_list'] = explode(',',$limit['action_list']);
            } else {
                $limit = array('status' => 1);
            }



            $opt_punish = $this->getPunish();
            $opt = array('行为组一'=>array(array('1','行为1'),array('2','行为2'),array('3','行为3'),array('4','行为4')),'行为组二'=>array(array('5','行为5'),array('6','行为6'),array('7','行为7'),array('8','行为8')));

            $builder->title(($aId == 0 ? '新增' : '编辑') . '行为限制')->keyId()
                ->keyTitle()
                ->keyText('frequency', '频率')
                ->keyChosen('punish', '处罚','',$opt_punish)
                ->keyBool('if_message', '是否发送提醒')
                ->keyTextArea('message_content', '处罚')
                ->keyChosen('action_list', '行为','',$opt)
                ->keyStatus()
                ->data($limit)
                ->buttonSubmit(U('editLimit'))->buttonBack()->display();
        }
    }


    public function setLimitStatus($ids, $status)
    {
        $builder = new AdminListBuilder();
        $builder->doSetStatus('action_limit', $ids, $status);
    }



    private function getPunish()
    {
        return array(
            array('logout_account',  '强制注销账户'),
            array('ban_account', '封停账户'),
        );
    }


}
