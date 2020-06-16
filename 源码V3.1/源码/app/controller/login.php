<?php
namespace BL\app\controller;

use BL\app\libs\Controller;

class login extends Controller
{
    public function index()
    {
        $data = array('title' => '用户登录');
        $this->put('login.php', $data);
    }
    public function sigin()
    {
        $username = $this->req->post('username');
        $password = $this->req->post('password');
        $chkcode = $this->req->post('chkcode');
        if ($username == '' || $password == '' || $chkcode == '') {
            echo json_encode(array('status' => 0, 'msg' => '选项填写不完整'));
            exit;
        }
        if (!$this->session->get('chkcode') || $this->session->get('chkcode') != strtolower($chkcode)) {
            echo json_encode(array('status' => 0, 'msg' => '验证码填写错误'));
            exit;
        }
        if ($user = $this->model()->select()->from('users')->where(array('fields' => 'uname=?', 'values' => array($username)))->fetchRow()) {
            $ip = $this->req->server('REMOTE_ADDR');
            if ($user['is_state'] === 0) {
                echo json_encode(array('status' => 0, 'msg' => '账号被禁用'));
                exit;
            }
				$update['last_ip']=$ip;
                $update['ctime']=time();
            if ($user['upasswd'] == sha1($password)) {
              	$this->model()->from('users')->updateSet($update)->where(array('fields' => 'uname=?', 'values' => array($username)))->update();
             	$ulevel = $this->model()->select()->from('ulevel')->where(array('fields' => 'id=?', 'values' => array($user['lid'])))->fetchRow();              
                $this->session->set('login_name', $username);
                $this->session->set('login_id', $user['id']);
                $this->session->set('login_lid', $user['lid']);   
                $this->session->set('login_gtitle', $ulevel['title']);               
                echo json_encode(array('status' => 1, 'msg' => '登录成功', 'url' => "../../"));
                exit;
            }
        }
        echo json_encode(array('status' => 0, 'msg' => '账号或密码不正确'));
        exit;
    }
    public function logout()
    {
        if ($this->req->session('login_name')) {
            $_SESSION['login_name'] = '';
            session_destroy();
        }
        $this->res->redirect("../../");
    }
}