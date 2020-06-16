<?php
namespace BL\app\controller;

use BL\app\libs\Controller;

class user extends controller
{
    public function index()
    {
        $uname = $this->session->get('login_name');
        $id = $this->session->get('login_id');
      	$user = $this->model()->select()->from('users')->where(array('fields' => 'uname=?', 'values' => array($uname)))->fetchRow();
     	$ulevel = $this->model()->select()->from('ulevel')->where(array('fields' => 'id=?', 'values' => array($user['lid'])))->fetchRow(); 
        $okorder = $this->model()->select()->from('orders')->where(array('fields' => '`status` = 3 and `uid` = '.$id))->count();  
        $order = $this->model()->select()->from('orders')->where(array('fields' => '`uid` = '.$id))->fetchAll();   
      	$oid = $this->req->get('oid');
        $noorder = $this->model()->select()->from('orders')->where(array('fields' => 'orderid=?', 'values' => array($oid)))->fetchRow();
     	$data = array('lists' => $order,'order' => $noorder,'user' => $user, 'gtitle' => $ulevel['title'], 'okorder' => $okorder);
        $this->put('user.php', $data);
       
    }
    public function sett()
    {
        $uname = $this->session->get('login_name');
      	$user = $this->model()->select()->from('users')->where(array('fields' => 'uname=?', 'values' => array($uname)))->fetchRow();
     	$ulevel = $this->model()->select()->from('ulevel')->where(array('fields' => 'id=?', 'values' => array($user['lid'])))->fetchRow(); 
     	$data = array('lists' => $user, 'gtitle' => $ulevel['title']);
        $this->put('user_sett.php', $data);
       
    }
    public function repwd()
    {
            $uname = $this->session->get('login_name');      
            $upass = $this->req->post('pass');
            $update['upasswd']=sha1($upass);      
            if ($this->model()->from('users')->updateSet($update)->where(array('fields' => 'uname=?', 'values' => array($uname)))->update()) {
                  echo json_encode(array('status' => 1, 'msg' => '修改成功', 'url' => $this->dir . 'admins'));
                  exit;
              }
              echo json_encode(array('status' => 0, 'msg' => '修改失败'));
              exit;
    }
}
  
  
  
