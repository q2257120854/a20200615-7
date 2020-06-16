<?php
namespace BL\app\controller;

use BL\app\libs\Controller;
use BL\app\Config;

class reg extends Controller
{
    public function index()
    {
        $data = array('title' => '用户注册');
        $this->put('reg.php', $data);
    }
    public function repass()
    {
        $data = array('title' => '找回密码');
        $this->put('repass.php', $data);
    }
    public function repwd()
    {
      $token = $this->req->get('token');     
      $users = $this->model()->select()->from('users')->where(array('fields' => 'token=?', 'values' => array($token)))->fetchRow();  
      if($token !=$users['token'])exit('非法请求，已记录ip');	      
      if((time()-7200)>$users['pwtime'])exit('非法请求，超出有效期');	
        $data = array('title' => '重置密码','token' =>$token);
      $this->put('repwd.php', $data);
      
    }
    public function dorepass()
    {
      $uname = $this->req->post('uname');
      $email = $this->req->post('email');
      $users = $this->model()->select()->from('users')->where(array('fields' => 'uname=?', 'values' => array($uname)))->fetchRow();
      $ciremail= $users['email'];
      if($email != $ciremail){
        echo json_encode(array('status' => 0, 'msg' => '账号匹配'));
        exit;
      }
      $data = array('pwtime' =>time() , 'token' => sha1($this->res->getRandomString(40)));       
      if ($this->model()->from('users')->updateSet($data)->where(array('fields' => 'uname=?', 'values' => array($uname)))->update()) {      
        $mailtpl = $this->model()->select()->from('mailtpl')->where(array('fields' => 'is_state=? and cname=?', 'values' => array(0, '找回密码')))->fetchRow();
        $mdata = [
          'sitename' => $this->config['sitename'],
          'token' => $data['token'],
          'siteurl' => 'http://'.$_SERVER['HTTP_HOST']
        ];
        $newData = $this->res->replaceMailTpl($mailtpl, $mdata);
        $subject = array('title' => $newData['title'], 'email' => $email, 'content' => $newData['content']);
        $this->res->sendMail($subject, $this->config);
         echo json_encode(array('status' => 1, 'msg' => '找回密码邮件发送成功！请留意邮件'));
        exit;

      }
    }
  
    public function resave()
    {       
     	$token = $this->req->post('token');
        $upass = $this->req->post('upasswd');
        $cirpwd = $this->req->post('rpasswd');
        if(!$token)exit(json_encode(array('status' => 0, 'msg' => '非法请求，已记录ip')));       
        if (strlen($upass) < 6 || strlen($upass) > 20) {
            echo json_encode(array('status' => 0, 'msg' => '登录密码长度在6-20位之间'));
            exit;
        }
        if ($upass != $cirpwd) {
            echo json_encode(array('status' => 0, 'msg' => '两次输入的密码匹配'));
            exit;
        }
        $data = array('pwtime' =>'1465164366' ,'token' =>'' ,'upasswd' => sha1($upass));     
        if ($this->model()->from('users')->updateSet($data)->where(array('fields' => 'token=?', 'values' => array($token)))->update()) {
            echo json_encode(array('status' => 1, 'msg' => '重置成功！请登陆', 'url' => $this->dir . '../../login'));
            exit;
        }
        echo json_encode(array('status' => 0, 'msg' => '设置保存失败'));
        exit;
    }
  
    public function save()
    {
        
        $data = array();
        if (isset($_POST)) {
            foreach ($_POST as $key => $val) {
                if ($key != 'uname' && $key != 'upasswd' && $key != 'rpasswd') {
                    $data[$key] = $this->req->post($key);
                }
            }
        }
        $uname = $this->req->post('uname');
        $upass = $this->req->post('upasswd');
        $cirpwd = $this->req->post('rpasswd');
        $email = $this->req->post('email');
        if ($uname == '' || $upass == '' || $cirpwd == ''|| $email == '') {
            echo json_encode(array('status' => 0, 'msg' => '选项填写不完整'));
            exit;
        }
        if ($this->model()->select()->from('users')->where(array('fields' => 'uname=?', 'values' => array($uname)))->count()) {
            echo json_encode(array('status' => 0, 'msg' => $uname . ' 账号已存在'));
            exit;
        }
        if (strlen($upass) < 6 || strlen($upass) > 20) {
            echo json_encode(array('status' => 0, 'msg' => '登录密码长度在6-20位之间'));
            exit;
        }
        if ($upass != $cirpwd) {
            echo json_encode(array('status' => 0, 'msg' => '两次输入的密码匹配'));
            exit;
        }
        $data = array('uname' => $uname, 'upasswd' => sha1($upass), 'is_state' => $is_state,'email' => $email, 'ckmail' => '1','is_state' => '1','lid' => '1');
        if ($this->model()->from('users')->insertData($data)->insert()) {
            echo json_encode(array('status' => 1, 'msg' => '注册成功！请登陆', 'url' => $this->dir . '../../login'));
            exit;
        }
        echo json_encode(array('status' => 0, 'msg' => '设置保存失败'));
        exit;
    }
}