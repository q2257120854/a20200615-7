<?php
namespace BL\app\controller\admin;

use BL\app\libs\Controller;

class link extends CheckAdmin
{
    public function index()
    {
        $is_state = isset($_GET['is_state']) ? $this->req->get('is_state') : -1 ;
        $filter = $this->req->get('filter');
        $cons = '';
        $consArr = [];
        if($is_state >= 0){
            $cons .= $cons ? ' and ' : '';
            $cons.= 'u.is_state = ?';
            $consArr[] = $is_state;
        }
        if($filter){
            $cons .= $cons ? ' and ' : '';
            $cons.= "u.title like ?";
            $consArr[] = '%' . $filter . '%';;
			
            $cons .= $cons ? ' and ' : '';
            $cons.= "u.url like ?";
            $consArr[] = '%' . $filter . '%';;
        }

        $lists = [];
        $page = $this->req->get('p');
        $page = $page ? $page : 1;
        $pagesize = 20;
        $totalsize = $this->model()->from('links u')->where(array('fields' => $cons, 'values' => $consArr))->count();
        if ($totalsize) {
            $totalpage = ceil($totalsize / $pagesize);
            $page = $page > $totalpage ? $totalpage : $page;
            $offset = ($page - 1) * $pagesize;
			
            $lists = $this->model()->select('u.*')->from('links u')->limit($pagesize)->offset($offset)->where(array('fields' => $cons, 'values' => $consArr))->orderby('u.id desc')->fetchAll();
        }
        $pagelist = $this->page->put(array('page' => $page, 'pagesize' => $pagesize, 'totalsize' => $totalsize, 'url' => '?is_state='.$is_state.'&filter='.$filter.'&p='));
      
        $search =[
            'is_state' => $is_state,
            'filter' => $filter
        ];
        $data = array('title' => '友情链接列表', 'lists' => $lists, 'pagelist' => $pagelist, 'search' => $search);
        $this->put('link.php', $data);
    }
    public function save()
    {
        $data = array();
        if (isset($_POST)) {
            foreach ($_POST as $key => $val) {
                if ($key != 'title' && $key != 'url' && $key != 'is_state') {
                    $data[$key] = $this->req->post($key);
                }
            }
        }
        $title = $this->req->post('title');
        $url = $this->req->post('url');
        $is_state = $this->req->post('is_state');
        if ($title == '' || $url == '') {
            echo json_encode(array('status' => 0, 'msg' => '选项填写不完整'));
            exit;
        }
        if ($this->model()->select()->from('links')->where(array('fields' => 'url=?', 'values' => array($url)))->count()) {
            echo json_encode(array('status' => 0, 'msg' => $url . ' 链接已存在'));
            exit;
        } 
        $data = $_POST;
        if ($this->model()->from('links')->insertData($data)->insert()) {
            echo json_encode(array('status' => 1, 'msg' => '设置保存成功', 'url' => $this->dir . 'link'));
            exit;
        }
        echo json_encode(array('status' => 0, 'msg' => '设置保存失败'));
        exit;
    }
    public function edit()
    {
        $data = array('title' => '编辑友情链接');
        $id = isset($this->action[3]) ? intval($this->action[3]) : 0;
        $admin = $this->model()->select()->from('links')->where(array('fields' => 'id=?', 'values' => array($id)))->fetchRow();      
        $admin['limits'] = json_decode($admin['limits'], true);
        $this->put('linkedit.php', $data += array('data' => $admin));
    }
    public function editsave()
    {
        $id = isset($this->action[3]) ? intval($this->action[3]) : 0;
        $data = array();
        if (isset($_POST)) {
            foreach ($_POST as $key => $val) {
                if ($key != 'title' && $key != 'url'&& $key != 'is_state') {
                    $data[$key] = $this->req->post($key);
                }
            }
        }
        $title = $this->req->post('title');
        $is_state = $this->req->post('is_state');
        $url = $this->req->post('url');
        $data = array('is_state' => $is_state, 'title' => $title, 'url' => $url);      
        
        $update=$_POST;     
      
        if ($this->model()->from('links')->updateSet($update)->where(array('fields' => 'id=?', 'values' => array($id)))->update()) {
            echo json_encode(array('status' => 1, 'msg' => '设置保存成功', 'url' => $this->dir . 'link'));
            exit;
        }
        echo json_encode(array('status' => 0, 'msg' => '设置保存失败'));
        exit;
    }
	
	/**
     * 批量变更
     */
    public function checkLink()
    {
        $ids = $this->req->post('ids');
        $status = $this->req->post('status');
        $idsarr = explode(',',$ids);
        if($status == 9){
            $res = $this->model()->from('links')->where(array( 'id' => $idsarr))->in()->delete();
            if($res)echo json_encode(array('status' => 1));exit;
            echo json_encode(array('status' => 0,'msg'=>'删除失败'));exit;
        }
        $config = $this->setConfig;
        //拼接sql
        $sql = "UPDATE ".$config::db()['prefix']."links SET `is_state` = ".$status." WHERE `id` IN (".$ids.")";
        $res = $this->model()->query($sql);
        if($res)echo json_encode(array('status' => 1));exit;
        echo json_encode(array('status' => 0,'msg'=>'处理失败'));exit;


    }
	
    public function del()
    {
        $id = $this->req->get('id');
        if ($id) {
            if ($this->model()->from('links')->where(array('fields' => 'id=?', 'values' => array($id)))->delete()) {
                echo json_encode(array('status' => 1));
                exit;
            }
        }
        echo json_encode(array('status' => 0));
        exit;
    }
}