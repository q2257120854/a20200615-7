<?php

namespace app\admin\controller;

use think\Lang;
use think\Validate;

class Column extends AdminControl
{

    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/column.lang.php');
    }

    /**
     * 栏目列表
     * @return type
     */
    public function index()
    {
        $model_class = Model('column');
        // 父ID
        $parent_id = input('param.parent_id') ? intval(input('param.parent_id')) : 0;
        // 列表
        $tmp_list = $model_class->getTreeClassList(3); //显示深度

        $column_list = array();

        if (is_array($tmp_list)) {
            foreach ($tmp_list as $k => $v) {
                if ($v['parent_id'] == $parent_id) {
                    //判断是否有子类
                    $v['have_child'] = 0;
                    if (@$tmp_list[$k + 1]['deep'] > $v['deep']) {
                        $v['have_child'] = 1;
                    }
                    $column_list[] = $v;
                }
            }
        }
        if (input('param.ajax') == '1') {
            //转码
            $output = json_encode($column_list);
            print_r($output);
            exit;
        } else {
            $column_module_list = $this->getColumnModule();
            $this->assign('column_module_list', $column_module_list);
            
            $this->assign('column_list', $column_list);
            $this->setAdminCurItem('index');
            return $this->fetch('index');
        }
    }

    /**
     * 栏目分类 新增
     */
    public function add()
    {
        $model_class = Model('column');
        if (request()->isPost()) {
            $column_module = input('post.column_module');
            $column_module_list = $this->getColumnModule();            
//            if(!in_array($column_module, $column_module_list)){
//                $this->error('param_error');
//            }
            // 验证
            $data = [
                'column_name' => input('post.column_name'),
                'parent_id' => intval(input('post.parent_id')),
                'column_order' => input('post.column_order'),
                'column_display' => input('post.column_display') ? 1 : 0,
                'column_module' => $column_module,
                'seo_title' => input('post.seo_title'),
                'seo_keywords' => input('post.seo_keywords'),
                'seo_description' => input('post.seo_description'),
            ];

            //验证器
            $column_validate = validate('column');
            if (!$column_validate->scene('add')->check($data)){
                $this->error($column_validate->getError());
            }

            $result = $model_class->add($data);
            if ($result) {
                $this->log(lang('ds_add') . lang('column') . '[' . input('post.column_name') . ']', 1);
                dsLayerOpenSuccess(lang('column_add_succ'));
            } else {
                $this->error(lang('column_add_fail'));
            }
        }
        $contion = array('parent_id' => 0);
        $data = $model_class->where($contion)->select();
        $column = [
            'column_name' => '',
            'column_display' => 1,
            'column_addtime' => '',
            'column_module' => 1,
        ];
        $this->assign('column', $column);
        $parent_list = $model_class->_get_tree($data, 0, $lev = 0);
        if (is_array($parent_list)) {
            foreach ($parent_list as $k => $v) {
                $parent_list[$k]['column_name'] = str_repeat("&nbsp;", $v['lev'] * 5) . $v['column_name'];
            }
        }
        $this->assign('parent_id', intval(input('param.parent_id')));
        $this->assign('parent_list', $parent_list);
        $this->setAdminCurItem('add');
        return $this->fetch('form');
    }

    /**
     * 栏目分类编辑
     */
    public function edit()
    {

        $model_class = Model('column');
        $id = intval(input('param.id'));
        if (request()->isPost()) {
            $column_module = input('post.column_module');
            $column_module_list = $this->getColumnModule();            
//            if(!in_array($column_module, $column_module_list)){
//                $this->error('param_error');
//            }
            
            //验证
            $data = [
                'column_name' => input('post.column_name'),
                'parent_id' => intval(input('post.parent_id')),
                'column_order' => input('post.column_order'),
                'column_display' => input('post.column_display') ? 1 : 0,
                'column_module' => $column_module,
                'seo_title' => input('post.seo_title'),
                'seo_keywords' => input('post.seo_keywords'),
                'seo_description' => input('post.seo_description'),
            ];
            //验证器
            $column_validate = validate('column');
            if (!$column_validate->scene('add')->check($data)){
                $this->error($column_validate->getError());
            }
            $result = $model_class->editColumn(array('column_id' => $id), $data);
            if ($result) {
                $this->log(lang('ds_edit') . lang('column') . '[' . input('post.column_name') . ']', 1);
                dsLayerOpenSuccess(lang('edit_succ'));
            } else {
                $this->error(lang('edit_fail'));
            }
        }

        $class_array = $model_class->getOneColumn($id);
        if (empty($class_array)) {
            $this->error(lang('param_error'));
        }
        $contion = array('parent_id' => 0);
        $data = $model_class->where($contion)->select();

        $parent_list = $model_class->_get_tree($data, 0, $lev = 0);
        if (is_array($parent_list)) {
            foreach ($parent_list as $k => $v) {
                $parent_list[$k]['column_name'] = str_repeat("&nbsp;", $v['lev'] * 5) . $v['column_name'];
            }
        }
        $this->assign('parent_list', $parent_list);
        $this->assign('parent_id', intval(input('param.parent_id')));

        $this->assign('column', $class_array);
        $this->setAdminCurItem('edit');
        return $this->fetch('form');
    }

    /**
     * 删除栏目分类
     */
    public function del()
    {
        $model_class = Model('column');
        if (intval(input('param.id')) > 0) {
            $array = array(intval(input('param.id')));

            $del_array = $model_class->getChildClass($array);
            if (is_array($del_array)) {
                foreach ($del_array as $k => $v) {
                    $model_class->del($v['column_id']);
                }
            }
            ds_json_encode(10000, lang('del_succ'));
        } else {
            ds_json_encode(10001, lang('del_fail'));
        }
    }

    /**
     * ajax操作
     */
    public function ajax()
    {
        $branch = input('param.branch');
        switch ($branch) {
            case 'column':
                $column_mod = model('column');
                $condition = array('column_id' => intval(input('param.id')));
                $update[input('param.column')] = input('param.value');
                $column_mod->editcolumn($condition, $update);
                echo 'true';
        }
    }

    /**
     * 获取所有分类模块类型
     * @return type
     */
    protected function getColumnModule(){
        return array(
            COLUMN_NEWS=>'新闻模块',COLUMN_PRODUCT=>'产品模块',COLUMN_CASES=>'案例模块',COLUMN_JOB=>'招聘模块',COLUMN_LINK=>'友情链接',COLUMN_MEMBER=>'会员中心'
        );
    }

    /**
     * 获取栏目列表,针对控制器下的栏目
     * @return array
     */
    protected function getAdminItemList()
    {
        $menu_array = array(
            array(
                'name' => 'index', 'text' => lang('ds_manage'), 'url' => url('Column/index')
            ), array(
                'name' => 'add', 'text' => lang('ds_add'), 'url' => "javascript:dsLayerOpen('".url('Column/add')."','".lang('ds_add')."')"
            ),
        );
        return $menu_array;
    }

}
