<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-3-7
 * Time: 下午1:25
 * @author 郑钟良<zzl@ourstu.com>
 */

namespace Admin\Controller;

use Admin\Builder\AdminListBuilder;
use Admin\Builder\AdminSortBuilder;
use Admin\Builder\AdminConfigBuilder;
use Admin\Model\AuthRuleModel;

/**
 * 后台角色控制器
 * Class RoleController
 * @package Admin\Controller
 * @郑钟良
 */
class RoleController extends AdminController
{
    protected $roleModel;
    protected $userRoleModel;
    protected $roleConfigModel;
    protected $roleGroupModel;

    public function _initialize()
    {
        parent::_initialize();
        $this->roleModel = D("Admin/Role");
        $this->userRoleModel = D('UserRole');
        $this->roleConfigModel = D('RoleConfig');
        $this->roleGroupModel=D('RoleGroup');
    }

    //角色基本信息及配置 start

    public function index($page = 1, $r = 20)
    {
        $map['status'] = array('egt', 0);
        $roleList = $this->roleModel->selectPageByMap($map, &$totalCount, $page, $r, 'sort asc');
        $map_group['id']=array('in',array_column($roleList,'group_id'));
        $group=$this->roleGroupModel->where($map_group)->field('id,name,title')->select();
        $group=array_combine(array_column($group,'id'),$group);
        foreach($roleList as &$val){
            $val['group']=$group[$val['group_id']]['title']."(".$group[$val['group_id']]['name'].")";
        }
        unset($val);

        $builder = new AdminListBuilder;
        $builder->meta_title = "角色列表";
        $builder->title("角色列表");
        $builder->buttonNew(U('Role/editRole'))->setStatusUrl(U('setStatus'))->buttonEnable()->buttonDisable()->button('删除', array('class' => 'btn ajax-post confirm', 'url' => U('setStatus', array('status' => -1)), 'target-form' => 'ids', 'confirm-info' => "确认删除角色？删除后不可恢复！"))->buttonSort(U('sort'));
        $builder->keyId()
            ->keyLink('title', '角色名', 'admin/role/user?id=###')
            ->keyText('name', '角色标识')
            ->keyText('group', '所属分组')
            ->keyText('description', '描述')
            ->keytext('sort', '排序')
            ->keyYesNo('type', '是否需要邀请才能注册')
            ->keyYesNo('audit', '注册后是否需要审核')
            ->keyStatus()
            ->keyCreateTime()
            ->keyUpdateTime()
            ->keyDoActionEdit('Role/editRole?id=###')
            ->keyDoAction('Role/configAuth?id=###', '默认信息配置')
            ->data($roleList)
            ->pagination($totalCount, $r)
            ->display('index');
    }

    /**
     * 编辑角色
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function editRole()
    {
        $aId = I('id', 0, 'intval');
        $is_edit = $aId ? 1 : 0;
        $title = $is_edit ? "编辑角色" : "新增角色";
        if (IS_POST) {
            $data['name'] = I('post.name', '', 'op_t');
            $data['title'] = I('post.title', '', 'op_t');
            $data['description'] = I('post.description', '', 'op_t');
            $data['group'] = I('post.group', 0, 'intval');
            $data['type'] = I('post.type', 0, 'intval');
            $data['audit'] = I('post.audit', 0, 'intval');
            $data['status'] = I('post.status', 1, 'intval');
            if ($is_edit) {
                $data['id'] = $aId;
                $result = $this->roleModel->update($data);
            } else {
                $result = $this->roleModel->insert($data);
            }
            if ($result) {
                $this->success($title . "成功", U('Role/index'));
            } else {
                $error_info = $this->roleModel->getError();
                $this->error($title . "失败！" . $error_info);
            }
        } else {
            $data['status'] = 1;
            $data['type'] = 0;
            $data['audit'] = 0;
            if ($is_edit) {
                $data = $this->roleModel->getByMap(array('id' => $aId));
            }
            $group=D('RoleGroup')->field('id,title')->select();
            $group=array_combine(array_column($group,'id'),array_column($group,'title'));
            if(!$group){
                $group=array(0=>'无分组');
            }else{
                $group=array_merge(array(0=>'无分组'),$group);
            }
            $builder = new AdminConfigBuilder;
            $builder->meta_title = $title;
            $builder->title($title)
                ->keyId()
                ->keyText('title', '角色名', '不能重复')
                ->keyText('name', '英文标识', '由英文字母、下划线组成，且不能重复')
                ->keyTextArea('description', '描述')
                ->keySelect('group', '所属分组', '',$group)
                ->keyRadio('type', '需要邀请注册', '默认为关闭，开启后，得到邀请的用户才能注册', array(1 => "开启", 0 => "关闭"))
                ->keyRadio('audit', '需要审核', '默认为关闭，开启后，用户审核后才能拥有该角色', array(1 => "开启", 0 => "关闭"))
                ->keyStatus()
                ->data($data)
                ->buttonSubmit(U('editRole'))
                ->buttonBack()
                ->display();
        }
    }

    /**
     * 对角色进行排序
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function sort($ids = null)
    {
        if (IS_POST) {
            $builder = new AdminSortBuilder;
            $builder->doSort('Role', $ids);
        } else {
            $map['status'] = array('egt', 0);
            $list = $this->roleModel->selectByMap($map, 'sort asc', 'id,title,sort');
            foreach ($list as $key => $val) {
                $list[$key]['title'] = $val['title'];
            }
            $builder = new AdminSortBuilder;
            $builder->meta_title = '角色排序';
            $builder->data($list);
            $builder->buttonSubmit(U('sort'))->buttonBack();
            $builder->display();
        }
    }

    /**
     * 角色状态设置
     * @param mixed|string $ids
     * @param $status
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function setStatus($ids, $status)
    {
        if ($status == 1) {
            $builder = new AdminListBuilder;
            $builder->doSetStatus('Role', $ids, $status);
        } else if ($status == 0) {
            $result = $this->checkSingleRoleUser($ids);
            if ($result['status']) {
                $builder = new AdminListBuilder;
                $builder->doSetStatus('Role', $ids, $status);
            } else {
                $this->error('角色' . $result['role']['name'] . '（' . $result["role"]["id"] . '）【' . $result["role"]["title"] . '】中存在单角色用户，移出单角色用户后才能禁用该角色！');
            }
        } else if ($status == -1) {//（真删除）
            $result = $this->checkSingleRoleUser($ids);
            if ($result['status']) {
                $result = $this->roleModel->where(array('id' => array('in', $ids)))->delete();
                if ($result) {
                    $this->success('删除成功！', U('Role/index'));
                } else {
                    $this->error('删除失败！');
                }
            } else {
                $this->error('角色' . $result['role']['name'] . '（' . $result["role"]["id"] . '）【' . $result["role"]["title"] . '】中存在单角色用户，移出单角色用户后才能禁用该角色！');
            }
        }
    }

    /**
     * 检测要删除的角色中是否存在单角色用户
     * @param $ids 要删除的角色ids
     * @return mixed
     * @author 郑钟良<zzl@ourstu.com>
     */
    private function checkSingleRoleUser($ids)
    {
        $ids = is_array($ids) ? $ids : explode(',', $ids);
        $error_role_id = 0; //出错的角色id
        foreach ($ids as $role_id) {
            //获取拥有该角色的用户ids
            $uids = $this->userRoleModel->where(array('role_id' => $role_id))->field('uid')->select();
            if (count($uids) > 0) { //拥有该角色
                $uids = array_unique($uids);

                //获取拥有其他角色的用户ids
                $have_uids = $this->userRoleModel->where(array('role_id' => array('not in', $ids), 'uid' => array('in', $uids)))->field('uid')->select();
                if ($have_uids) {
                    $have_uids = array_unique($have_uids);

                    //获取不拥有其他角色的用户ids
                    $not_have = array_diff($uids, $have_uids);
                    if (count($not_have) > 0) {
                        $error_role_id = $role_id;
                        break;
                    }
                } else {
                    $error_role_id = $role_id;
                    break;
                }
            }
        }
        unset($role_id, $uids, $have_uids, $not_have);

        $result['status'] = 1;
        if ($error_role_id) {
            $result['role'] = $this->roleModel->where(array('id' => $error_role_id))->field('id,name,title')->find();
            $result['status'] = 0;
        }
        return $result;
    }

    //角色基本信息及配置 end

    //角色分组 start

    public function group()
    {
        $group=$this->roleGroupModel->field('id,title,update_time')->select();
        foreach($group as &$val){
            $map['group_id']=$val['id'];
            $roles=$this->roleModel->selectByMap($map,'id asc','id');
            $val['roles']=explode(',',array_column($roles,'id'));
        }
        unset($roles,$val);
        $builder=new AdminListBuilder;
        $builder->title('角色分组（同组角色互斥，即同一分组下的角色不能同时被用户拥有）')
            ->buttonNew(U('Role/editGroup'))
            ->keyId()
            ->keyText('title','标题')
            ->keyText('roles','分组下的角色id')
            ->keyUpdateTime()
            ->keyDoActionEdit('Role/editGroup?id=###')
            ->keyDoAction('Role/deleteGroup?id=###','删除')
            ->data($group)
            ->display();
    }

    public function editGroup()
    {
        $aGroupId=I('id',0,'intval');
        $is_edit=$aGroupId?1:0;
        $title=$is_edit?'编辑分组':'新增分组';
        if(IS_POST){
            $data['title']=I('post.title','','op_t');
            $data['update_time']=time();
            if($is_edit){
                $result=$this->roleGroupModel->where(array('id'=>$aGroupId))->save($data);
            }else{
                $result=$this->roleGroupModel->add($data);
            }
            if($result){
                $this->success("{$title}成功！",U('Role/group'));
            }else{
                $this->error("{$title}失败！".$this->roleGroupModel->getError());
            }
        }else{
            $data=array();
            if($is_edit){
                $data=$this->roleGroupModel->where(array('id'=>$aGroupId))->find();
            }
            $builder=new AdminConfigBuilder;
            $builder->title($title);
            $builder->keyId()
                ->keyText('title','标题')
                ->buttonSubmit()
                ->buttonBack()
                ->data($data)
                ->display();
        }
    }

    /**
     * 删除分组（真删除）
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function deleteGroup()
    {
        $aGroupId=I('id',0,'intval');
        if(!$aGroupId){
            $this->error('参数错误！');
        }
        $this->roleModel->where(array('group_id'=>$aGroupId))->setField('group_id',0);
        $result=$this->roleGroupModel->where(array('id'=>$aGroupId))->delete();
        if($result){
            $this->success('删除成功！');
        }else{
            $this->error('删除失败！');
        }
    }

    //角色分组end

    //角色其他配置 start

    /**
     * 默认权限（前台、后台）配置
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function configAuth()
    {
        $aRoleId = I('id', 0, 'intval');
        if (!$aRoleId) {
            $this->error('请选择角色！');
        }
        $map = getRoleConfigMap('rules', $aRoleId);
        $aType = I('type', 0, 'intval'); //权限设置类型：1为前台权限设置，0为后台权限设置
        if (IS_POST) {
            if (isset($_POST['rules'])) {
                sort($_POST['rules']);
                $_POST['rules'] = implode(',', array_unique($_POST['rules']));
            }
            $oldRule = $this->roleConfigModel->where($map)->find();
            if ($oldRule) {
                if ($aType == 1) { //前台
                    $data['value'] = $this->getMergedRules($oldRule['value'], explode(',', $_POST['rules']), 'neq');
                } else { //后台
                    $data['value'] = $this->getMergedRules($oldRule['value'], explode(',', $_POST['rules']), 'eq');
                }
                $result = $this->roleConfigModel->saveData($map, $data);
            } else {
                $data = $map;
                $data['value'] = $_POST['rules'];
                $result = $this->roleConfigModel->addData($data);
            }
            if ($result === false) {
                $this->error('操作失败' . $this->roleConfigModel->getError());
            } else {
                $this->success('操作成功!');
            }
        } else {

            R('Admin/AuthManager/updateRules'); //远程调用控制器的操作方法，进行后台节点配置的url作为规则存入auth_rule，执行新节点的插入,已有节点的更新,无效规则的删除三项任务

            $mRole_list = $this->roleModel->field('id,title')->select();

            $rules = $this->roleConfigModel->where($map)->getField('value');

            if ($aType == 1) { //前台
                $node_list = A('Admin/AuthManager')->getNodeListFromModule(D('Common/Module')->getAll()); //预处理规则，去掉未安装的模块
                $map_main = array('module' => array('neq', 'admin'), 'type' => AuthRuleModel::RULE_MAIN, 'status' => 1);
                $map_child = array('module' => array('neq', 'admin'), 'type' => AuthRuleModel::RULE_URL, 'status' => 1);
                $this->meta_title = '用户前台授权';
                $tpl = 'auth'; //模板地址
                $tab = 'auth';
            } else { //后台
                $node_list = $this->returnNodes();
                $map_main = array('module' => 'admin', 'type' => AuthRuleModel::RULE_MAIN, 'status' => 1);
                $map_child = array('module' => 'admin', 'type' => AuthRuleModel::RULE_URL, 'status' => 1);
                $this->meta_title = '访问授权';
                $tpl = 'authadmin'; //模板地址
                $tab = 'authAdmin';
            }

            $main_rules = M('AuthRule')->where($map_main)->getField('name,id');
            $child_rules = M('AuthRule')->where($map_child)->getField('name,id');
            $this->assign('main_rules', $main_rules);
            $this->assign('auth_rules', $child_rules);
            $this->assign('node_list', $node_list);
            $this->assign('role_list', $mRole_list);
            $this->assign('this_role', array('id'=>$aRoleId,'rules'=>$rules));
            $this->assign('tab', $tab);
            $this->display($tpl);
        }

    }

    /**
     * 角色默认积分配置
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function config()
    {
        $aRoleId = I('id', 0, 'intval');
        if (!$aRoleId) {
            $this->error('请选择角色！');
        }
        $map = getRoleConfigMap('score', $aRoleId);
        if (IS_POST) {
            $aPostKey = I('post.post_key', '', 'op_t');
            $post_key = explode(',', $aPostKey);
            $config_value = array();
            foreach ($post_key as $val) {
                if($val!=''){
                    $config_value[$val] = I('post.' . $val, 0, 'intval');
                }
            }
            unset($val);
            $data['value'] = json_encode($config_value, true);
            if ($this->roleConfigModel->where($map)->find()) {
                $result = $this->roleConfigModel->saveData($map, $data);
            } else {
                $data = array_merge($map, $data);
                $result = $this->roleConfigModel->addData($data);
            }
            if ($result) {
                $this->success('操作成功！', U('Admin/Role/config', array('id' => $aRoleId)));
            } else {
                $this->error('操作失败！' . $this->roleConfigModel->getError());
            }
        } else {
            $mRole_list = $this->roleModel->field('id,title')->select();

            //获取默认配置值
            $score = $this->roleConfigModel->where($map)->getField('value');
            $score = json_decode($score, true);

            //获取member表中积分字段$score_keys
            $model = D('Ucenter/Score');
            $score_keys = $model->getTypeList(array('status' => array('GT', -1)));

            $post_key = '';
            foreach ($score_keys as &$val) {
                $post_key .= ',score' . $val['id'];
                $val['value'] = $score['score' . $val['id']]; //写入默认值
            }
            unset($val);

            $this->meta_title = '角色默认积分配置';
            $this->assign('score_keys', $score_keys);
            $this->assign('post_key', $post_key);
            $this->assign('role_list', $mRole_list);
            $this->assign('this_role', array('id' => $aRoleId));
            $this->assign('tab', 'config');
            $this->display();
        }
    }

    /**
     * 角色默认头像配置
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function configAvatar()
    {
        $aRoleId = I('id', 0, 'intval');
        if (!$aRoleId) {
            $this->error('请选择角色！');
        }
        $map = getRoleConfigMap('avatar', $aRoleId);
        $data['data'] = '';
        if (IS_POST) {
            $data['value'] = I('post.avatar_id', 0, 'intval');
            if ($this->roleConfigModel->where($map)->find()) {
                if ($data['value'] == 0) { //使用系统默认头像
                    $result = $this->roleConfigModel->where($map)->delete();
                } else {
                    $result = $this->roleConfigModel->saveData($map, $data);
                }
            } else {
                if ($data['value'] != 0) {
                    $data = array_merge($map, $data);
                    $result = $this->roleConfigModel->addData($data);
                }
            }
            if ($result) {
                $this->success('操作成功！', U('Admin/Role/configAvatar', array('id' => $aRoleId)));
            } else {
                $this->error('操作失败！' . $this->roleConfigModel->getError());
            }
        } else {
            $avatar_id = $this->roleConfigModel->where($map)->getField('value');
            $mRole_list = $this->roleModel->field('id,title')->select();
            $this->assign('role_list', $mRole_list);
            $this->assign('this_role', array('id' => $aRoleId, 'avatar' => $avatar_id));
            $this->assign('tab', 'configAvatar');
            $this->display();
        }
    }

    /**
     * 角色默认头衔配置
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function configRank()
    {
        $aRoleId = I('id', 0, 'intval');
        if (!$aRoleId) {
            $this->error('请选择角色！');
        }
        $map = getRoleConfigMap('rank', $aRoleId);
        if (IS_POST) {
            $data['value']='';
            if (isset($_POST['ranks'])) {
                sort($_POST['ranks']);
                $data['value']= implode(',', array_unique($_POST['ranks']));
            }
            $aReason['reason'] = I('post.reason', '', 'op_t');
            $data['data']=json_encode($aReason,true);
            if ($this->roleConfigModel->where($map)->find()) {
                $result = $this->roleConfigModel->saveData($map, $data);
            } else {
                $data = array_merge($map, $data);
                $result = $this->roleConfigModel->addData($data);
            }
            if ($result) {
                $this->success('操作成功！', U('Admin/Role/configrank', array('id' => $aRoleId)));
            } else {
                $this->error('操作失败！' . $this->roleConfigModel->getError());
            }
        } else {
            $mRole_list = $this->roleModel->field('id,title')->select();
            $mRole_list=array_combine(array_column($mRole_list,'id'),$mRole_list);

            //获取默认配置值
            $rank = $this->roleConfigModel->where($map)->field('value,data')->find();
            if($rank){
                $rank['data'] = json_decode($rank['data'], true);
                if(!$rank['data']['reason']){
                    $rank['data']['reason']="{$mRole_list[$aRoleId]['title']}(角色)默认拥有该头衔！";
                }
            }else{
                $rank['data']['reason']="{$mRole_list[$aRoleId]['title']}(角色)默认拥有该头衔！";
                $rank['value']=array();
            }

            //获取头衔列表
            $model = D('Rank');
            $list = $model->field('id,uid,title,logo,create_time,types')->select();
            $canApply=$unApply=array();
            foreach ($list as $val) {
                $val['name'] =query_user(array('nickname'),$val['uid']);
                $val['name']=$val['name']['nickname'];
                if($val['types']){
                    $canApply[]=$val;
                }else{
                    $unApply[]=$val;
                }
            }
            unset($val);

            $this->assign('can_apply', $canApply);
            $this->assign('un_apply', $unApply);
            $this->assign('reason', $rank['data']['reason']);
            $this->assign('role_list', $mRole_list);
            $this->assign('this_role', array('id' => $aRoleId,'ranks'=>$rank['value']));
            $this->assign('tab', 'rank');
            $this->display();
        }
    }

    /**
     * 角色扩展资料配置 及 注册时要填写的资料配置
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function configField()
    {
        $aRoleId = I('id', 0, 'intval');
        if (!$aRoleId) {
            $this->error('请选择角色！');
        }
        $aType = I('get.type', 0, 'intval'); //扩展资料设置类型：1注册时要填写资料配置，0扩展资料字段设置

        if($aType){//注册时要填写资料配置
            $type='register_expend_field';
        }else{//扩展资料字段设置
            $type='expend_field';
        }
        $map = getRoleConfigMap($type, $aRoleId);
        if (IS_POST) {
            $data['value']='';
            if (isset($_POST['fields'])) {
                sort($_POST['fields']);
                $data['value'] = implode(',', array_unique($_POST['fields']));
            }
            if ($this->roleConfigModel->where($map)->find()) {
                $result = $this->roleConfigModel->saveData($map, $data);
            } else {
                $data=array_merge($map,$data);
                $result = $this->roleConfigModel->addData($data);
            }
            if ($result === false) {
                $this->error('操作失败' . $this->roleConfigModel->getError());
            } else {
                $this->success('操作成功!');
            }
        } else {
            $aType = I('get.type', 0, 'intval'); //扩展资料设置类型：1注册时要填写资料配置，0扩展资料字段设置

            $mRole_list = $this->roleModel->field('id,title')->select();

            $fields = $this->roleConfigModel->where($map)->getField('value');

            if ($aType == 1) { //注册时要填写资料配置
                $map_fields = getRoleConfigMap('expend_field', $aRoleId);
                $expend_fields = $this->roleConfigModel->where($map_fields)->getField('value');
                $field_list=$expend_fields?$this->getExpendField($expend_fields):array();
                $this->meta_title = '注册时要填写资料配置';
                $tpl = 'fieldregister'; //模板地址
                $tab = 'fieldRegister';
            } else { //扩展资料字段设置
                $field_list=$this->getExpendField();
                $this->meta_title = '扩展资料字段设置';
                $tpl = 'field'; //模板地址
                $tab = 'field';
            }
            $this->assign('field_list', $field_list);
            $this->assign('role_list', $mRole_list);
            $this->assign('this_role', array('id'=>$aRoleId,'fields'=>$fields));
            $this->assign('tab', $tab);
            $this->display($tpl);
        }
    }
    //角色其他配置 end

    /**
     * 拼接权限ids
     * @param $oldRules
     * @param $rules
     * @param string $isAdmin 是否为后台权限，neq：前台，eq:后台
     * @return mixed
     * @author 郑钟良<zzl@ourstu.com>
     */
    private function getMergedRules($oldRules, $rules, $isAdmin = 'neq')
    {
        $map = array('module' => array($isAdmin, 'admin'), 'status' => 1);
        $otherRules = M('AuthRule')->where($map)->field('id')->select();
        $oldRulesArray = explode(',', $oldRules);
        $otherRulesArray = getSubByKey($otherRules, 'id');

        //1.删除全部非Admin模块下的权限，排除老的权限的影响
        //2.合并新的规则
        foreach ($otherRulesArray as $key => $v) {
            if (in_array($v, $oldRulesArray)) {
                $key_search = array_search($v, $oldRulesArray);
                if ($key_search !== false)
                    array_splice($oldRulesArray, $key_search, 1);
            }
        }

        return str_replace(',,', ',', implode(',', array_unique(array_merge($oldRulesArray, $rules))));
    }

    /**
     * 获取扩展字段列表
     * @param string $in
     * @return mixed
     * @author 郑钟良<zzl@ourstu.com>
     */
    private function getExpendField($in='')
    {
        if($in!=''){
            $in=is_array($in)?$in:explode(',',$in);
            $map_field['id']=array('in',$in);
        }
        $map['status'] = array('egt', 0);
        $profileList = D('field_group')->where($map)->order("sort asc")->select();//获取扩展字段分组

        $fieldSettingModel=D('field_setting');
        $type_default = array(
            'input' => '单行文本框',
            'radio' => '单选按钮',
            'checkbox' => '多选框',
            'select' => '下拉选择框',
            'time' => '日期',
            'textarea' => '多行文本框'
        );
        $child_type = array(
            'string' => '字符串',
            'phone' => '手机号码',
            'email' => '邮箱',
            'number' => '数字'
        );

        $map_field['status']= array('egt', 0);
        foreach($profileList as $key=>&$val){
            //获取分组下字段列表
            $map_field['profile_group_id'] = $val['id'];
            $field_list = $fieldSettingModel->where($map_field)->order("sort asc")->select();
            foreach ($field_list as &$vl) {
                $vl['form_type'] = $type_default[$vl['form_type']];
                $vl['child_form_type'] = $child_type[$vl['child_form_type']];
            }
            unset($vl);
            if($field_list){
                $val['field_list']=$field_list;
            }else{
                unset($profileList[$key]);
            }
        }
        unset($key,$val,$field_list);
        return $profileList;
    }

    /**
     * 上传图片（上传默认头像）
     * @author huajie <banhuajie@163.com>
     */
    public function uploadPicture()
    {
        //TODO: 用户登录检测

        /* 返回标准数据 */
        $return = array('status' => 1, 'info' => '上传成功', 'data' => '');

        /* 调用文件上传组件上传文件 */
        $Picture = D('Picture');
        $pic_driver = C('PICTURE_UPLOAD_DRIVER');
        $info = $Picture->upload(
            $_FILES,
            C('PICTURE_UPLOAD'),
            C('PICTURE_UPLOAD_DRIVER'),
            C("UPLOAD_{$pic_driver}_CONFIG")
        ); //TODO:上传到远程服务器
        /* 记录图片信息 */
        if ($info) {
            $return['status'] = 1;
            empty($info['download']) && $info['download'] = $info['file'];
            $return = array_merge($info['download'], $return);
            $return['path256'] = getThumbImageById($return['id'], 256, 256);
            $return['path128'] = getThumbImageById($return['id'], 128, 128);
            $return['path64'] = getThumbImageById($return['id'], 64, 64);
            $return['path32'] = getThumbImageById($return['id'], 32, 32);
        } else {
            $return['status'] = 0;
            $return['info'] = $Picture->getError();
        }
        /* 返回JSON数据 */
        $this->ajaxReturn($return);
    }
} 