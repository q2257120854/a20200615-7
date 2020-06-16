<?php

namespace app\admin\controller;

use think\Lang;
use think\Validate;

class Navigation extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/nav.lang.php');
    }

    /**
     * 导航管理
     */
    public function index() {
        $model_nav = Model('nav');
        $condition = array();

        $nav_display = intval(input('param.nav_display'));
        if ($nav_display > 0) {
            $condition['nav_display'] = $nav_display;
        }

        $nav_list = $model_nav->getNavList($condition, '*', 15);
        $this->assign('nav_list', $nav_list);
        $this->assign('show_page', $model_nav->page_info->render());
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 添加导航
     */
    public function add() {
        if (request()->isPost()) {
            $data = array(
                'nav_title' => input('post.nav_title'),
                'nav_url' => input('post.nav_url'),
                'nav_location' => input('post.nav_location'),
                'nav_display' => input('post.nav_display'),
                'nav_new_open' => input('post.nav_new_open') == 1 ? 'target="_blank"' : 'target="_self"',
                'nav_order' => input('post.nav_order'),
                'nav_is_show' => input('post.nav_is_show') ? 1 : 0,
            );
            //验证器
            $nav_validate = validate('Nav');
            if (!$nav_validate->scene('add')->check($data)){
                $this->error($nav_validate->getError());
            }
            $result = model('nav')->addNav($data);
            if ($result) {
                $this->log(lang('ds_nav') . '-' . lang('add_succ') . '[' . $data['nav_title'] . ']', null);
                $this->success(lang('add_succ'), url('navigation/index'));
            } else {
                $this->error(lang('add_fail'));
            }
        } else {
            $nav = array(
                'nav_new_open' => 1,
                'nav_is_show' => 1,
                'nav_display' => 1,
            );
            $this->assign('nav', $nav);
            $this->setAdminCurItem('add');
            return $this->fetch('form');
        }
    }

    /**
     * 修改导航
     */
    public function edit() {
        $nav_id = intval(input('param.nav_id'));
        if (!request()->isPost()) {
            $nav = model('nav')->getOneNav(['nav_id' => $nav_id]);
            $this->assign('nav', $nav);
            $this->setAdminCurItem('edit');
            return $this->fetch('form');
        } else {
            $data = array(
                'nav_title' => input('post.nav_title'),
                'nav_url' => input('post.nav_url'),
                'nav_location' => input('post.nav_location'),
                'nav_display' => input('post.nav_display'),
                'nav_new_open' => input('post.nav_new_open') == 1 ? 'target="_blank"' : 'target="_self"',
                'nav_order' => input('post.nav_order'),
                'nav_is_show' => input('post.nav_is_show') ? 1 : 0,
            );
            //验证器
            $nav_validate = validate('Nav');
            if (!$nav_validate->scene('add')->check($data)){
                $this->error($nav_validate->getError());
            }
            $result = model('nav')->editNav(['nav_id' => $nav_id], $data);
            if ($result) {
                $this->log(lang('ds_nav') . '-' . lang('edit_succ') . '[' . $data['nav_title'] . ']', null);
                $this->success(lang('edit_succ'), url('navigation/index'));
            } else {
                $this->error(lang('edit_fail'));
            }
        }
    }

    /**
     * 删除导航
     */
    public function del() {
        $nav_id = intval(input('param.nav_id'));
        if ($nav_id) {
            $condition['nav_id'] = $nav_id;
            $result = model('nav')->delNav($condition);
            if ($result) {
                $this->log(lang('ds_nav') . '-' . lang('del_succ') . '[' . $nav_id . ']', null);
                ds_json_encode(10000, lang('del_succ'));
            } else {
                ds_json_encode(10001, lang('del_fail'));
            }
        } else {
            ds_json_encode(10001, lang('del_fail'));
        }
    }

    /**
     * ajax操作
     */
    public function ajax() {
        $branch = input('param.branch');
        switch ($branch) {
            case 'nav':
                $nav_mod = model('nav');
                $condition = array('nav_id' => intval(input('param.id')));
                $update[input('param.column')] = input('param.value');
                $nav_mod->editnav($condition, $update);
                echo 'true';
        }
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     * @return string
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index', 'text' => lang('ds_manage'), 'url' => url('Navigation/index')
            ), array(
                'name' => 'add', 'text' => lang('ds_add'), 'url' => url('Navigation/add')
            )
        );
        if (request()->action() == 'edit') {
            $menu_array[] = array(
                'name' => 'edit', 'text' => lang('ds_edit'), 'url' => url('Navigation/edit')
            );
        }
        return $menu_array;
    }

}

?>
