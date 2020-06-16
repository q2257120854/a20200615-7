<?php
namespace BL\app\controller\admin;

use BL\app\libs\Controller;

class user extends CheckAdmin
{
    public function index()
    {
       $lid = $this->req->get('lid') ? $this->req->get('lid') : -1;//用户组id
        $is_ste = isset($_GET['is_ste']) ? $this->req->get('is_ste') : -1 ;
        $uname = $this->req->get('uname');
        $cons = '';
        $consArr = [];
        if($lid >= 0){
            $cons .= $cons ? ' and ' : '';
            $cons.= 'u.lid = ?';
            $consArr[] = $lid;
        }
        if($is_ste >= 0){
            $cons .= $cons ? ' and ' : '';
            $cons.= 'u.is_ste = ?';
            $consArr[] = $is_ste;
        }
        if($uname){
            $cons .= $cons ? ' and ' : '';
            $cons.= "u.uname like ?";
            $consArr[] = '%' . $uname . '%';;
        }

        $lists = [];
        $page = $this->req->get('p');
        $page = $page ? $page : 1;
        $pagesize = 20;
        $totalsize = $this->model()->from('users u')->where(array('fields' => $cons, 'values' => $consArr))->count();
        if ($totalsize) {
            $totalpage = ceil($totalsize / $pagesize);
            $page = $page > $totalpage ? $totalpage : $page;
            $offset = ($page - 1) * $pagesize;
            $lists = $this->model()->select('u.*,l.title')->from('users u')->limit($pagesize)->left('ulevel l')->on('l.id=u.lid')->join()->offset($offset)->where(array('fields' => $cons, 'values' => $consArr))->orderby('u.id desc')->fetchAll();
        }
        $pagelist = $this->page->put(array('page' => $page, 'pagesize' => $pagesize, 'totalsize' => $totalsize, 'url' => '?lid='.$lid.'&is_ste='.$is_ste.'&uname='.$uname.'&p='));
        $ulevel = $this->model()->select()->from('ulevel')->fetchAll();
        $search =[
            'lid' => $lid,
            'is_ste' => $is_ste,
            'uname' => $uname
        ];
        $data = array('title' => '用户列表', 'lists' => $lists, 'ulevel' => $ulevel, 'pagelist' => $pagelist, 'search' => $search);
        $this->put('user.php', $data);
    }
    public function save()
    {
        $data = array();
        if (isset($_POST)) {
            foreach ($_POST as $key => $val) {
                if ($key != 'uname' && $key != 'upasswd' && $key != 'email' && $key != 'is_state') {
                    $data[$key] = $this->req->post($key);
                }
            }
        }
        $uname = $this->req->post('uname');
        $upass = $this->req->post('upasswd');
        $is_state = $this->req->post('is_state');
        $email = $this->req->post('email');
        $last_ip = $this->req->post('last_ip');
        if ($uname == '' || $upass == '') {
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
      	$_POST['upasswd']=sha1($upass);        
        $data = $_POST;
        if ($this->model()->from('users')->insertData($data)->insert()) {
            echo json_encode(array('status' => 1, 'msg' => '设置保存成功', 'url' => $this->dir . 'user'));
            exit;
        }
        echo json_encode(array('status' => 0, 'msg' => '设置保存失败'));
        exit;
    }
    public function edit()
    {
        $data = array('title' => '编辑账号信息');
        $id = isset($this->action[3]) ? intval($this->action[3]) : 0;
        $admin = $this->model()->select()->from('users')->where(array('fields' => 'id=?', 'values' => array($id)))->fetchRow();      
        $ulevel = $this->model()->select()->from('ulevel')->fetchAll();
        $admin['limits'] = json_decode($admin['limits'], true);
        $data['ulevel'] = $ulevel;
        $this->put('useredit.php', $data += array('data' => $admin));
    }
    public function editsave()
    {
        $id = isset($this->action[3]) ? intval($this->action[3]) : 0;
        $data = array();
        if (isset($_POST)) {
            foreach ($_POST as $key => $val) {
                if ($key != 'uname' && $key != 'upasswd' && $key != 'cirpwd' && $key != 'is_state') {
                    $data[$key] = $this->req->post($key);
                }
            }
        }
        $upass = $this->req->post('upasswd');
        $is_state = $this->req->post('is_state');
        $email = $this->req->post('email');
        $last_ip = $this->req->post('last_ip');
        $ckmail = $this->req->post('ckmail');
        $data = array('is_state' => $is_state, 'last_ip' => $last_ip, 'email' => $email, 'ckmail' => $ckmail);      
        if ($upass) {
            if (strlen($upass) < 6 || strlen($upass) > 20) {
                echo json_encode(array('status' => 0, 'msg' => '登录密码长度在6-20位之间'));
                exit;
            }
            $data += array('upasswd' => sha1($upass));
        }
      	unset($_POST['cirpwd']);//去除数据库没有的字段
      if($_POST['upasswd']!=""){
        $_POST['upasswd']=sha1($upass);//从新定义密码
      }else{      
      	unset($_POST['upasswd']);//去除数据库没有的字段
      }
        $update=$_POST;     
      
        if ($this->model()->from('users')->updateSet($update)->where(array('fields' => 'id=?', 'values' => array($id)))->update()) {
            echo json_encode(array('status' => 1, 'msg' => '设置保存成功', 'url' => $this->dir . 'user'));
            exit;
        }
        echo json_encode(array('status' => 0, 'msg' => '设置保存失败'));
        exit;
    }
	
	/**
     * 批量变更
     */
    public function checkUser()
    {
        $ids = $this->req->post('ids');
        $status = $this->req->post('status');
        $idsarr = explode(',',$ids);
        if($status == 9){
            $res = $this->model()->from('users')->where(array( 'id' => $idsarr))->in()->delete();
            if($res)echo json_encode(array('status' => 1));exit;
            echo json_encode(array('status' => 0,'msg'=>'删除失败'));exit;
        }
        $config = $this->setConfig;
        //拼接sql
        $sql = "UPDATE ".$config::db()['prefix']."users SET `is_state` = ".$status." WHERE `id` IN (".$ids.")";
        $res = $this->model()->query($sql);
        if($res)echo json_encode(array('status' => 1));exit;
        echo json_encode(array('status' => 0,'msg'=>'处理失败'));exit;


    }
	
    public function del()
    {
        $id = $this->req->get('id');
        if ($id) {
            if ($this->model()->from('users')->where(array('fields' => 'id=?', 'values' => array($id)))->delete()) {
                echo json_encode(array('status' => 1));
                exit;
            }
        }
        echo json_encode(array('status' => 0));
        exit;
    }
}