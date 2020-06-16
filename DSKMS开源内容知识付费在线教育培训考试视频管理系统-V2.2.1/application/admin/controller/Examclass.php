<?php

namespace app\admin\controller;

use think\Lang;

/**
 * ============================================================================
 * DSMall多用户商城
 * ============================================================================
 * 版权所有 2014-2028 长沙德尚网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.csdeshang.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 控制器
 */
class Examclass extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/examclass.lang.php');
    }

    /**
     * 题库管理
     */
    public function index() {
        $examclass_model = model('examclass');
        //父ID
        $parent_id = input('param.examclass_parent_id') ? intval(input('param.examclass_parent_id')) : 0;
        //列表
        $store_id = 0;
        $tmp_list = $examclass_model->getTreeClassList(2, $store_id);
        $class_list = array();
        if (is_array($tmp_list)) {
            foreach ($tmp_list as $k => $v) {
                if ($v['examclass_parent_id'] == $parent_id) {
                    //判断是否有子类
                    $v['have_child'] = 0;
                    if (isset($tmp_list[$k + 1]['deep']) && $tmp_list[$k + 1]['deep'] > $v['deep']) {
                        $v['have_child'] = 1;
                    }
                    $class_list[] = $v;
                }
            }
        }
        if (input('param.ajax') == '1') {
            //转码
            $output = json_encode($class_list);
            print_r($output);
            exit;
        } else {
            $this->assign('class_list', $class_list);
            $this->setAdminCurItem('index');
            return $this->fetch('index');
        }
    }

    /**
     * 题库分类 新增
     */
    public function add() {
        $examclass_model = model('examclass');
        if (request()->isPost()) {
            //验证
            $data = [
                'examclass_name' => input('param.examclass_name'),
                'examclass_sort' => input('param.examclass_sort')
            ];
            $examclass_validate = validate('examclass');
            if (!$examclass_validate->scene('add')->check($data)) {
                $this->error($examclass_validate->getError());
            } else {

                $insert_array = array();
                $insert_array['examclass_name'] = trim(input('param.examclass_name'));
                $insert_array['examclass_parent_id'] = intval(input('param.examclass_parent_id'));
                $insert_array['examclass_sort'] = trim(input('param.examclass_sort'));
                $insert_array['store_id'] = 0;

                $result = $examclass_model->addExamclass($insert_array);
                if ($result) {
                    $this->log(lang('ds_add') . lang('examclass_index_class') . '[' . input('examclass_name') . ']', 1);
                    dsLayerOpenSuccess(lang('ds_common_save_succ'));
                } else {
                    $this->error(lang('ds_common_save_fail'));
                }
            }
        } else {
            /**
             * 父类列表，只取到第三级
             */
            $store_id = 0;
            $parent_list = $examclass_model->getTreeClassList(1,$store_id);
            if (is_array($parent_list)) {
                foreach ($parent_list as $k => $v) {
                    $parent_list[$k]['examclass_name'] = str_repeat("&nbsp;", $v['deep'] * 2) . $v['examclass_name'];
                }
            }
            $this->assign('examclass_parent_id', intval(input('param.examclass_parent_id')));
            $this->assign('parent_list', $parent_list);
            return $this->fetch('form');
        }
    }

    /**
     * 题库分类编辑
     */
    public function edit() {
        $examclass_model = model('examclass');

        $examclass_id = intval(input('param.examclass_id'));

        if (request()->isPost()) {
            /**
             * 验证
             */
            $data = [
                'examclass_name' => input('param.examclass_name'),
                'examclass_sort' => input('param.examclass_sort')
            ];
            $examclass_validate = validate('examclass');
            if (!$examclass_validate->scene('edit')->check($data)) {
                $this->error($examclass_validate->getError());
            } else {

                $update_array = array();
                $update_array['examclass_name'] = trim(input('post.examclass_name'));
                $update_array['examclass_sort'] = trim(input('post.examclass_sort'));
                $condition = array(
                    'store_id' => 0,
                    'examclass_id' => $examclass_id,
                );
                $result = $examclass_model->editExamclass($condition, $update_array);
                if ($result >= 0) {
                    $this->log(lang('ds_edit') . lang('examclass_index_class') . '[' . input('post.examclass_name') . ']', 1);
                    dsLayerOpenSuccess(lang('ds_common_save_succ'));
                } else {
                    $this->error(lang('ds_common_save_fail'));
                }
            }
        } else {
            $condition = array(
                'store_id' => 0,
                'examclass_id' => $examclass_id,
            );
            $class_array = $examclass_model->getOneExamclass($condition);
            if (empty($class_array)) {
                $this->error(lang('param_error'));
            }

            $this->assign('class_array', $class_array);
            return $this->fetch('form');
        }
    }

    /**
     * 删除分类
     */
    public function del() {
        $examclass_model = model('examclass');

        $examclass_id = input('param.examclass_id');
        $examclass_id_array = ds_delete_param($examclass_id);
        if ($examclass_id_array === FALSE) {
            ds_json_encode('10001', lang('param_error'));
        }


        $del_array = $examclass_model->getChildClass($examclass_id_array);
        if (is_array($del_array)) {
            foreach ($del_array as $k => $v) {
                $condition = array(
                    'store_id' => 0,
                    'examclass_id' => $v['examclass_id'],
                );
                $examclass_model->delExamclass($condition);
            }
        }
        $this->log(lang('ds_add') . lang('examclass_index_class') . '[ID:' . $examclass_id . ']', 1);
        ds_json_encode(10000, lang('examclass_index_del_succ'));
    }

    /**
     * ajax操作
     */
    public function ajax() {
        switch (input('param.branch')) {
            /**
             * 分类：验证是否有重复的名称
             */
            case 'examclass_name':
                $examclass_model = model('examclass');
                $condition = array(
                    'store_id' => 0,
                    'examclass_id' => intval(input('param.id')),
                );
                $class_array = $examclass_model->getOneExamclass($condition);

                $condition['examclass_name'] = trim(input('param.value'));
                $condition['examclass_parent_id'] = $class_array['examclass_parent_id'];
                $condition['examclass_id'] = array('neq', intval(input('param.id')));
                $class_list = $examclass_model->getExamclassList($condition);
                if (empty($class_list)) {
                    $update_array = array();
                    $update_array['examclass_id'] = intval(input('param.id'));
                    $update_array['examclass_name'] = trim(input('param.value'));
                    $examclass_model->update($update_array);
                    echo 'true';
                    exit;
                } else {
                    echo 'false';
                    exit;
                }
                break;
            /**
             * 分类： 排序 显示 设置
             */
            case 'examclass_sort':
                $examclass_model = model('examclass');
                $update_array = array();
                $update_array['examclass_id'] = intval(input('param.id'));
                $update_array[input('param.column')] = trim(input('param.value'));
                $result = $examclass_model->update($update_array);
                echo 'true';
                exit;
                break;
            /**
             * 分类：添加、修改操作中 检测类别名称是否有重复
             */
            case 'check_class_name':
                $examclass_model = model('examclass');
                $condition['examclass_name'] = trim(input('param.examclass_name'));
//                $condition['examclass_parent_id'] = intval(input('param.examclass_parent_id'));
                $condition['examclass_id'] = array('neq', intval(input('param.examclass_id')));
                $class_list = $examclass_model->getExamclassList($condition);
                if (empty($class_list)) {
                    echo 'true';
                    exit;
                } else {
                    echo 'false';
                    exit;
                }
                break;
        }
    }

    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => lang('ds_manage'),
                'url' => url('Examclass/index')
            ),
            array(
                'name' => 'add',
                'text' => lang('ds_new'),
                'url' => "javascript:dsLayerOpen('" . url('Examclass/add') . "','" . lang('examclass_add') . "')",
            )
        );
        return $menu_array;
    }

}
