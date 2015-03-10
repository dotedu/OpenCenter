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

    public function _initialize()
    {
        parent::_initialize();
        $this->roleModel = D("Admin/Role");
        $this->userRoleModel=D('UserRole');
        $this->roleConfigModel=D('RoleConfig');
    }

    //角色基本信息及配置 start


    public function index($page = 1, $r = 20)
    {
        $map['status']=array('egt',0);
        $roleList = $this->roleModel->selectPageByMap($map,&$totalCount,$page,$r,'sort asc');

        $builder = new AdminListBuilder;
        $builder->mata_title = "角色列表";
        $builder->title("角色列表");
        $builder->buttonNew(U('Role/editRole'))->setStatusUrl(U('setStatus'))->buttonEnable()->buttonDisable()->button( '删除',array('class'=>'btn ajax-post confirm','url'=>U('setStatus',array('status'=>-1)),'target-form'=>'ids','confirm-info'=>"确认删除角色？删除后不可恢复！"))->buttonSort(U('sort'));
        $builder->keyId()
            ->keyLink('title', '角色名', 'admin/role/user?id=###')
            ->keyText('name', '角色标识')
            ->keyText('description', '描述')
            ->keytext('sort','排序')
            ->keyYesNo('type', '是否需要邀请才能注册')
            ->keyStatus()
            ->keyCreateTime()
            ->keyUpdateTime()
            ->keyDoActionEdit('Role/editRole?id=###')
            ->keyDoAction('Role/configAuth?id=###','权限配置')
            ->keyDoAction('Role/config?id=###','默认资料配置')
            ->keyDoAction('Role/configExpend?id=###','默认扩展资料配置')
            ->data($roleList)
            ->pagination($totalCount, $r)
            ->display('index');
    }

    public function editRole(){
        $aId=I('id',0,'intval');
        $is_edit=$aId?1:0;
        $title=$is_edit?"编辑角色":"新增角色";
        if(IS_POST){
            $data['name']=I('post.name','','op_t');
            $data['title']=I('post.title','','op_t');
            $data['description']=I('post.description','','op_t');
            $data['type']=I('post.type',0,'intval');
            $data['status']=I('post.status',1,'intval');
            if($is_edit){
                $data['id']=$aId;
                $result=$this->roleModel->update($data);
            }else{
                $result=$this->roleModel->insert($data);
            }
            if($result){
                $this->success($title."成功",U('Role/index'));
            }else{
                $error_info=$this->roleModel->getError();
                $this->error($title."失败！".$error_info);
            }
        }else{
            $data['status']=1;
            $data['type']=0;
            if($is_edit){
                $data=$this->roleModel->getByMap(array('id'=>$aId));
            }
            $builder=new AdminConfigBuilder;
            $builder->meta_title=$title;
            $builder->title($title)
                ->keyId()
                ->keyText('title','角色名','不能重复')
                ->keyText('name','英文标识','由英文字母、下划线组成，且不能重复')
                ->keyTextArea('description','描述')
                ->keyRadio('type','需要邀请注册','默认为关闭，开启后，得到邀请的用户才能注册',array(1=>"开启",0=>"关闭"))
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
    public function sort($ids=null){
        if (IS_POST) {
            $builder = new AdminSortBuilder;
            $builder->doSort('Role', $ids);
        } else {
            $map['status'] = array('egt', 0);
            $list = $this->roleModel->selectByMap($map,'sort asc','id,title,sort');
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
    public function setStatus($ids,$status){
        if($status==1){
            $builder=new AdminListBuilder;
            $builder->doSetStatus('Role',$ids,$status);
        }else if($status==0){
            $result=$this->checkSingleRoleUser($ids);
            if($result['status']){
                $builder=new AdminListBuilder;
                $builder->doSetStatus('Role',$ids,$status);
            }else{
                $this->error('角色'.$result['role']['name'].'（'.$result["role"]["id"].'）【'.$result["role"]["title"].'】中存在单角色用户，移出单角色用户后才能禁用该角色！');
            }
        }else if($status==-1){
            $result=$this->checkSingleRoleUser($ids);
            if($result['status']){
                $result=$this->roleModel->where(array('id'=>array('in',$ids)))->delete();
                if($result){
                    $this->success('删除成功！',U('Role/index'));
                }else{
                    $this->error('删除失败！');
                }
            }else{
                $this->error('角色'.$result['role']['name'].'（'.$result["role"]["id"].'）【'.$result["role"]["title"].'】中存在单角色用户，移出单角色用户后才能禁用该角色！');
            }
        }
    }

    /**
     * 检测要删除的角色中是否存在单角色用户
     * @param $ids 要删除的角色ids
     * @return mixed
     * @author 郑钟良<zzl@ourstu.com>
     */
    private function checkSingleRoleUser($ids){
        $ids=is_array($ids)?$ids:explode(',',$ids);
        $error_role_id=0;//出错的角色id
        foreach($ids as $role_id){
            //获取拥有该角色的用户ids
            $uids=$this->userRoleModel->where(array('role_id'=>$role_id))->field('uid')->select();
            if(count($uids)>0){//拥有该角色
                $uids=array_unique($uids);

                //获取拥有其他角色的用户ids
                $have_uids=$this->userRoleModel->where(array('role_id'=>array('not in',$ids),'uid'=>array('in',$uids)))->field('uid')->select();
                if($have_uids){
                    $have_uids=array_unique($have_uids);

                    //获取不拥有其他角色的用户ids
                    $not_have=array_diff($uids,$have_uids);
                    if(count($not_have)>0){
                        $error_role_id=$role_id;
                        break;
                    }
                }else{
                    $error_role_id=$role_id;
                    break;
                }
            }
        }
        unset($role_id,$uids,$have_uids,$not_have);

        $result['status']=1;
        if($error_role_id){
            $result['role']=$this->roleModel->where(array('id'=>$error_role_id))->field('id,name,title')->find();
            $result['status']=0;
        }
        return $result;
    }

    //角色基本信息及配置 end

    //角色其他配置 start

    /**
     * 默认权限配置
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function configAuth()
    {
        if(IS_POST){
            $aRoleId=I('post.id',0,'intval');
            $aType=I('post.type',0,'intval');//权限设置类型：1为前台权限设置，0为后台权限设置
            if (isset($_POST['rules'])) {
                sort($_POST['rules']);
                $_POST['rules'] = implode(',', array_unique($_POST['rules']));
            }
            $map=getRoleConfigMap('rules',$aRoleId);
            $oldRule = $this->roleConfigModel->where($map)->find();

            if($oldRule){
                if($aType==1){//前台
                    $data['value'] = $this->getMergedRules($oldRule['value'], explode(',', $_POST['rules']), 'neq');
                }else{//后台
                    $data['value'] = $this->getMergedRules($oldRule['value'], explode(',', $_POST['rules']), 'eq');
                }
                $data['update_time']=time();
                $result=$this->roleConfigModel->where($map)->save($data);
            }else{
                $data=$this->initRoleConfigData('rules',$aRoleId,$_POST['rules']);
                $result=$this->roleConfigModel->add($data);
            }
            if ($result === false) {
                $this->error('操作失败' . $this->roleConfigModel->getError());
            } else {
                $this->success('操作成功!');
            }
        }else{
            $aRoleId=I('get.id',0,'intval');
            $aType=I('get.type',0,'intval');//权限设置类型：1为前台权限设置，0为后台权限设置
            if(!$aRoleId){
                $this->error('参数错误！');
            }

            R('Admin/AuthManager/updateRules');//远程调用控制器的操作方法，进行后台节点配置的url作为规则存入auth_rule，执行新节点的插入,已有节点的更新,无效规则的删除三项任务

            $mRole_list=$this->roleModel->field('id,title')->select();
            $mThis_role=$this->roleModel->where(array('id'=>$aRoleId))->field('id,name,title')->find();
            $map=getRoleConfigMap('rules',$aRoleId);
            $mThis_role['rules'] = $this->roleConfigModel->where($map)->getField('value');

            if($aType==1){//前台
                $node_list = A('Admin/AuthManager')->getNodeListFromModule(D('Common/Module')->getAll());//预处理规则，去掉未安装的模块
                $map_main = array('module' => array('neq', 'admin'), 'type' => AuthRuleModel::RULE_MAIN, 'status' => 1);
                $map_child = array('module' => array('neq', 'admin'), 'type' => AuthRuleModel::RULE_URL, 'status' => 1);
                $this->meta_title = '用户前台授权';
                $tpl='Role/Auth/config';//模板地址
            }else{//后台
                $node_list = $this->returnNodes();
                $map_main = array('module' => 'admin', 'type' => AuthRuleModel::RULE_MAIN, 'status' => 1);
                $map_child = array('module' => 'admin', 'type' => AuthRuleModel::RULE_URL, 'status' => 1);
                $this->meta_title = '访问授权';
                $tpl='Role/Auth/configadmin';//模板地址
            }

            $main_rules = M('AuthRule')->where($map_main)->getField('name,id');
            $child_rules = M('AuthRule')->where($map_child)->getField('name,id');

            $this->assign('main_rules', $main_rules);
            $this->assign('auth_rules', $child_rules);
            $this->assign('node_list', $node_list);
            $this->assign('auth_role',$mRole_list);
            $this->assign('this_role', $mThis_role);
            $this->display($tpl);
        }

    }

    /**
     * 角色默认值配置
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function config(){
        $aRoleId=I('id',0,'intval');

        $mRole_list=$this->roleModel->field('id,title')->select();
        $this->assign('auth_role',$mRole_list);

        //获取member表中积分字段$score_keys
        $model = D('Ucenter/Score');
        $score_keys= $model->getTypeList(array('status' => array('GT', -1)));
        $this->assign('score_keys',$score_keys);

        //获取默认配置值
        $map=getRoleConfigMap('score',$aRoleId);
        $score = $this->roleConfigModel->where($map)->getField('value');
        $score=json_decode($score,true);
        $this->assign('default_score',$score);
        $this->display();
    }

    //角色其他配置 end



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
     * 初始化角色配置表数据
     * @param string $type 类型
     * @param int $role_id 角色id
     * @param $value
     * @param string $other_value 数据库中data字段
     * @return mixed|string
     * @author 郑钟良<zzl@ourstu.com>
     */
    private function initRoleConfigData($type='rules',$role_id=0,$value,$other_value=''){
        $data=getRoleConfigMap($type,$role_id);
        $data['update_time']=time();
        $data['value']=$value;
        $data['data']=json_encode($other_value,true);
        $data['type']=isset($data['type'])?$data['type']:'';
        return $data;
    }
} 