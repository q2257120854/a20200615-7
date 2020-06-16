<?php
namespace BL\app\controller\admin;

use BL\app\libs\Controller;

class ulevel extends CheckAdmin
{
    public function index()
    {
        $data = array('title' => '等级名称设置');
        $lists = $this->model()->select()->from('ulevel')->fetchAll();
        $data += array('lists' => $lists);
        $this->put('ulevel.php', $data);
    }
    public function editsave()
    {
        $id = isset($this->action[3]) ? intval($this->action[3]) : 0;
        $data = isset($_POST) ? $_POST : false;
        if ($data) {
            foreach ($data as $key => $val) {
                $data[$key] = $this->req->post($key);
            }
            if ($this->model()->from('ulevel')->updateSet($data)->where(array('fields' => 'id=?', 'values' => array($id)))->update()) {
                echo json_encode(array('status' => 1, 'msg' => '设置保存成功'));
                exit;
            }
        }
        echo json_encode(array('status' => 0, 'msg' => '设置保存失败'));
        exit;
    }
}