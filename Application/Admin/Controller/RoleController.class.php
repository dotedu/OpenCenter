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

/**
 * 后台角色控制器
 * Class RoleController
 * @package Admin\Controller
 * @郑钟良
 */
class RoleController extends AdminController
{
    protected $RoleModel;

    public function _initialize()
    {
        parent::_initialize();
        $this->RoleModel = D("Admin/Role");
    }

    public function index($page = 1, $r = 20)
    {
        $map['status']=array('egt',0);
        $roleList = $this->RoleModel->selectPageByMap($map,&$totalCount,$page,$r,'sort asc');

        $builder = new AdminListBuilder;
        $builder->mata_title = "角色列表";
        $builder->title("角色列表");
        $builder->buttonNew(U('Role/editRole'))->setStatusUrl(U('setStatus'))->buttonEnable()->buttonDisable()->buttonDelete()->buttonSort(U('sort'));
        $builder->keyId()
            ->keyLink('title', '角色名', 'admin/role/roleConfig?id=###')
            ->keyText('name', '角色标识')
            ->keyText('description', '描述')
            ->keytext('sort','排序')
            ->keyYesNo('type', '是否需要邀请才能注册')
            ->keyStatus()
            ->keyCreateTime()
            ->keyUpdateTime()
            ->keyDoActionEdit('Role/editRole?id=###')
            ->data($roleList)
            ->pagination($totalCount, $r)
            ->display();
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
                $result=$this->RoleModel->update($data);
            }else{
                $result=$this->RoleModel->insert($data);
            }
            if($result){
                $this->success($title."成功",U('Role/index'));
            }else{
                $error_info=$this->RoleModel->getError();
                $this->error($title."失败！".$error_info);
            }
        }else{
            $data['status']=1;
            $data['type']=0;
            if($is_edit){
                $data=$this->RoleModel->getByMap(array('id'=>$aId));
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
            $list = $this->RoleModel->selectByMap($map,'sort asc','id,title,sort');
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

    public function setStatus($ids,$status){
        $builder=new AdminListBuilder;
        $builder->doSetStatus('Role',$ids,$status);
    }

} 