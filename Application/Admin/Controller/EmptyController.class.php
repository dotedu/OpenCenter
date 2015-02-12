<?php
namespace Admin\Controller;

use Think\Controller;

class EmptyController extends Controller
{
    public function index()
    {
        //根据当前控制器名来判断要执行那个城市的操作
        $cityName = CONTROLLER_NAME;
        $this->city($cityName);
    }

    //注意 city方法 本身是 protected 方法
    protected function city($name)
    {
        //和$name这个城市相关的处理
        echo '当前城市' . $name;
    }

    public function _empty($name)
    {
        // $controller= A(CONTROLLER_NAME.'/admin');
        // dump(APP_PATH . '/' . CONTROLLER_NAME . '/' . 'Controller' . '/' . 'WeiboController.class.php');

        require_once(APP_PATH . CONTROLLER_NAME . '/' . 'Controller' . '/' .CONTROLLER_NAME. 'Controller.class.php');
        $controller = A( 'Admin/'.CONTROLLER_NAME);
        $action=ACTION_NAME;
        $controller->$action();

    }

}