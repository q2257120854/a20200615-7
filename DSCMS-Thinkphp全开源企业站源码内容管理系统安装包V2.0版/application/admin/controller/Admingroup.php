<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/10 0010
 * Time: 17:09
 */

namespace app\admin\controller;


use think\exception\PDOException;
use think\Lang;

class Admingroup extends AdminControl
{
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/admingroup.lang.php');
    }

    /**
     * 管理权限组
     * @return mixed
     */
    public function index()
    {
        $model_admingroup = Model('admingroup');
        $admingroup_list = $model_admingroup->getAdminGroupList('*');
        $this->assign('admin_group_list', $admingroup_list);
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 添加权限组
     * @return mixed
     */
    public function add()
    {
        if (request()->isPost()) {
            $admin_group_model = model('admingroup');
            //判断权限组名是否存在
            if ($admin_group_model->getOneAdmingroup(['group_name' => input('post.group_name')])) {
                $this->error(lang('admin_group_existence'));
            }
            $limit_str = '';
            $permission_array = input('post.permission/a');
            if (is_array($permission_array)) {
                $limit_str = implode('|', $permission_array);
            }
            
            $data['group_limits'] = ds_encrypt($limit_str, MD5_KEY . md5(input('post.group_name')));
            $data['group_name'] = input('post.group_name');
            $admingroup_validate = validate('admingroup');

            if (!$admingroup_validate->scene('add')->check($data)){
                $this->error($admingroup_validate->getError());
            }
            if ($admin_group_model->addAdminGroup($data)) {
                $this->log(lang('ds_add') . lang('ds_admin_group') . '[' . input('post.group_name') . ']', 1);
                dsLayerOpenSuccess(lang('admin_group_add_succ'));
            } else {
                $this->error(lang('admin_group_add_fail'));
            }
        } else {
            $this->assign('admin_array', 'add');
            $this->assign('limit', $this->permission());
            $this->setAdminCurItem('add');
            return $this->fetch('form');
        }
    }

    /**
     * 编辑权限组
     * @return type
     */
    public function edit()
    {
        $admin_group_model = model('admingroup');
        $group_id = intval(input('param.group_id'));
        $group_info = $admin_group_model->getOneAdmingroup(array('group_id' => $group_id));
        if (empty($group_info)) {
            $this->error(lang('admin_set_admin_not_exists'));
        }
        if (request()->isPost()) {
            $limit_str = '';
            $permission_array = input('post.permission/a');
            if (is_array($permission_array)) {
                $limit_str = implode('|', $permission_array);
            }
            
            $limit_str = ds_encrypt($limit_str, MD5_KEY . md5(input('post.group_name')));

            $data = [
                'group_name' => input('post.group_name'),
                'group_limits' => $limit_str
            ];
            $admingroup_validate = validate('admingroup');
            if (!$admingroup_validate->scene('edit')->check($data)){
                $this->error($admingroup_validate->getError());
            }
            $update = $admin_group_model->editAdminGroup(array('group_id' => $group_id), $data);
            if ($update) {
                $this->log(lang('ds_edit') . lang('group_limits') . '[' . input('post.group_limits') . ']', 1);
                dsLayerOpenSuccess(lang('admin_group_edit_succ'));
            } else {
                $this->error(lang('admin_group_edit_fail'));
            }
        } else {
            //解析已有权限
            $hlimit = ds_decrypt($group_info['group_limits'], MD5_KEY . md5($group_info['group_name']));
            $group_info['group_limits'] = explode('|', $hlimit);
            $this->assign('admin_array', 'edit');
            $this->assign('group_info', $group_info);
            $this->assign('limit', $this->permission());
            $this->setAdminCurItem('edit');
            return $this->fetch('form');
        }
    }

    /**
     * 删除权限组
     */
    public function del()
    {
        $group_id = input('param.group_id');
        if (empty($group_id)) {
            $this->error(lang('param_error'));
        }
        $result = db('admingroup')->delete($group_id);
        if ($result) {
            ds_json_encode(10000, lang('admin_group_del_succ'));
        } else {
            ds_json_encode(10001, lang('admin_group_del_fail'));
        }
    }

    /**
     * 取得所有权限项
     * @author csdeshang
     * @return array
     */
    private function permission()
    {
        $limit = $this->limitList();
        if (is_array($limit)) {
            foreach ($limit as $k => $v) {
                if (is_array($v['child'])) {
                    $tmp = array();
                    foreach ($v['child'] as $key => $value) {
                        $controller = (!empty($value['controller'])) ? $value['controller'] : $v['controller'];
                        if (strpos($controller, '|') == false) {//controller参数不带|
                            $limit[$k]['child'][$key]['action'] = rtrim($controller . '.' . str_replace('|', '|' . $controller . '.', $value['action']), '.');
                        } else {//controller参数带|
                            $tmp_str = '';
                            if (empty($value['action'])) {
                                $limit[$k]['child'][$key]['action'] = $controller;
                            } elseif (strpos($value['action'], '|') == false) {//action参数不带|
                                foreach (explode('|', $controller) as $v1) {
                                    $tmp_str .= "$v1.{$value['action']}|";
                                }
                                $limit[$k]['child'][$key]['action'] = rtrim($tmp_str, '|');
                            } elseif (strpos($value['action'], '|') != false && strpos($controller, '|') != false) {//action,controller都带|，交差权限
                                foreach (explode('|', $controller) as $v1) {
                                    foreach (explode('|', $value['action']) as $v2) {
                                        $tmp_str .= "$v1.$v2|";
                                    }
                                }
                                $limit[$k]['child'][$key]['action'] = rtrim($tmp_str, '|');
                            }
                        }
                    }
                }
            }
            return $limit;
        } else {
            return array();
        }
    }

    /*
    * 权限选择列表
    */
    function limitList()
    {
        $_limit = array(
            array('name' => lang('ds_dashboard_manage'), 'child' => array(
                array('name' => lang('ds_welcome'), 'action' => null, 'controller' => 'Index'),
            )),
            array('name' => lang('ds_setting_manage'), 'child' => array(
                array('name' => lang('ds_config'), 'action' => null, 'controller' => 'Config'),
                array('name' => lang('ds_db'), 'action' => null, 'controller' => 'Db'),
                array('name' => lang('ds_adminlog'), 'action' => null, 'controller' => 'AdminLog'),
            )),
            array('name' => lang('ds_personnel_manage'), 'child' => array(
                array('name' => lang('ds_member'), 'action' => null, 'controller' => 'Member'),
                array('name' => lang('ds_admin'), 'action' => null, 'controller' => 'Admin'),
                array('name' => lang('ds_admin_group'), 'action' => null, 'controller' => 'AdminGroup'),
            )),
            array('name' => lang('ds_content_manage'), 'child' => array(
                array('name' => lang('ds_column'), 'action' => null, 'controller' => 'Column'),
                array('name' => lang('ds_news'), 'action' => null, 'controller' => 'News'),
                array('name' => lang('ds_product'), 'action' => null, 'controller' => 'Product'),
                array('name' => lang('ds_cases'), 'action' => null, 'controller' => 'Cases'),
                array('name' => lang('ds_adv'), 'action' => null, 'controller' => 'Adv'),
            )),
            array('name' => lang('ds_operation_manage'), 'child' => array(
                array('name' => lang('ds_message'), 'action' => null, 'controller' => 'Message'),
                array('name' => lang('ds_job'), 'action' => null, 'controller' => 'Job'),
                array('name' => lang('ds_jobcv'), 'action' => null, 'controller' => 'Jobcv'),
                array('name' => lang('ds_link'), 'action' => null, 'controller' => 'Link'),
                array('name' => lang('ds_nav'), 'action' => null, 'controller' => 'Navigation'),
            )),
            array('name' => lang('ds_wechat_manage'), 'child' => array(
                array('name' => lang('ds_wechat_setting'), 'action' => null, 'controller' => 'Wechatsetting'),
                array('name' => lang('ds_wechat_menu'), 'action' => null, 'controller' => 'Wechatmenu'),
                array('name' => lang('ds_wechat_keywords'), 'action' => null, 'controller' => 'Wechatkeywords'),
                array('name' => lang('ds_wechat_member'), 'action' => null, 'controller' => 'Wechatmember'),
                array('name' => lang('ds_wechat_push'), 'action' => null, 'controller' => 'Wechatpush'),
            )),
        );

        return $_limit;
    }

    /**
     * 获取栏目列表,针对控制器下的栏目
     * @return array
     */
    protected function getAdminItemList()
    {
        $menu_array = array(
            array(
                'name' => 'index', 'text' => lang('ds_manage'), 'url' => url('Admingroup/index')
            ), array(
                'name' => 'add', 'text' => lang('ds_add'), 'url' => "javascript:dsLayerOpen('".url('Admingroup/add')."','".lang('ds_add')."')"

            ),
        );
        return $menu_array;
    }
}