<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-3-3
 * Time: 下午5:10
 * @author:xjw129xjt(肖骏涛) xjt@ourstu.com
 */


require_once(OC_ROOT.'Model/base.php');
class User extends base{

    function doLogin($args){
        $username = $args['username'];
        $password = $args['password'];
        $this->check_username($username, $email, $mobile, $type);

        switch ($type) {
            case 1:
                $sql = "SELECT * FROM `".$this->tablePre."ucenter_member` WHERE username='$username'";
                $res = $this->db->getOne($sql);
                break;
            case 2:
                $sql = "SELECT * FROM `".$this->tablePre."ucenter_member` WHERE email='$email'";
                $res = $this->db->getOne($sql);
                break;
            case 3:
                $sql = "SELECT * FROM `".$this->tablePre."ucenter_member` WHERE mobile='$mobile'";
                $res = $this->db->getOne($sql);
                break;
            default:
                return 0; //参数错误
        }

        if($this->think->think_ucenter_md5($password) === $res['password']){
            $time = time();
            $ip = get_client_ip(1);
            $uid= $res['id'];
            $update_sql = "UPDATE `".$this->tablePre."ucenter_member` SET last_login_time=$time ,last_login_ip=$ip WHERE id=$uid;";
            $this->db->query($update_sql);

            $user = $this->db->getOne("SELECT * FROM `".$this->tablePre."member` WHERE uid='$uid'");
            if (1 != $user['status']) {
                return '用户未激活或已禁用！';
            }


            $this->db->query("UPDATE `".$this->tablePre."member` SET last_login_time=$time ,last_login_ip=$ip，login=login+1 WHERE uid=$uid;");
            /* 记录登录SESSION和COOKIES */
            $auth = array(
                'uid' => $user['uid'],
                'username' => $res['username'],
                'last_login_time' => $user['last_login_time'],
            );

            session_start();
            $_SESSION[$this->session_pre]['user_auth']=$auth;
            $_SESSION[$this->session_pre]['user_auth_sign']=$this->think->data_auth_sign($auth);
            //TODO 记住登陆待做

            return $uid;
        }
        return false;

    }


    function doGetUserInfo($where=''){
        $user = $this->db->getOne("SELECT * FROM `".$this->tablePre."member` WHERE ".$where);
        $ucenter_member = $this->db->getOne("SELECT * FROM `".$this->tablePre."ucenter_member` WHERE id=".$user['uid']);
        $user = array_merge($user,$ucenter_member);
        return $user;
    }

    function doSynLogin($uid){
        $time =time();
        $user = $this->doGetUserInfo('uid='.$uid);
        $appList = $this->db->getAll("SELECT * FROM `".$this->tablePre."sso_app` WHERE status=1");
            $synstr = '';
            foreach($appList as &$app) {
                $app['config_data'] = unserialize($app['config']);
                if($app['config_data']['SSO_SWITCH'] && $app['id'] != $this->appid) {
                    $synstr .= '<script type="text/javascript" src="'.$app['url'].'/'.$app['path'].'?time='.$time.'&code='.urlencode($this->think->think_encrypt('action=synLogin&username='.$user['username'].'&uid='.$user['uid'].'&password='.$user['password']."&time=".$time)).'"></script>';
                }
            }
            return $synstr;
    }

    function doSynLogout(){
        $time =time();
        $appList = $this->db->getAll("SELECT * FROM `".$this->tablePre."sso_app` WHERE status=1");
        $synstr = '';
        foreach($appList as &$app) {
            $app['config_data'] = unserialize($app['config']);
            if($app['config_data']['SSO_SWITCH'] && $app['id'] != $this->appid) {
                $synstr .= '<script type="text/javascript" src="'.$app['url'].'/'.$app['path'].'?time='.$time.'&code='.urlencode($this->think->think_encrypt('action=synLogout&time='.$time)).'"></script>';
            }
        }
        return $synstr;
    }


} 