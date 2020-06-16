<?php

namespace BL\app\controller;

use BL\app\libs\Controller;

class product extends Controller
{
    public function index()
    {
        $id = $this->req->get('id');
        $pass = $this->req->get('pwd');
        $data = $this->model()->select()->from('goods')->where(array('fields' => 'id=?', 'values' => array($id)))->fetchRow(); 
      //if($data['pwd']&&$data['pwd']!=$pass)die("查看密码错误");//判断并验证密码查看
     	 if($this->session->get('login_lid')){
                $data['price'] = $data["money{$this->session->get('login_lid')}"];
              }else{
                $data['price'] =  $data['gmoney'] ;
              }
        $this->put('product.php', $data);
    }}
