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
class  Goodsclass extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/goodsclass.lang.php');
    }

    /**
     * 分类管理
     */
    public function goods_class() {
        $goodsclass_model = model('goodsclass');
        //父ID
        $parent_id = input('param.gc_parent_id') ? intval(input('param.gc_parent_id')) : 0;

        //列表
        $tmp_list = $goodsclass_model->getTreeClassList(3);
        $class_list = array();
        if (is_array($tmp_list)) {
            foreach ($tmp_list as $k => $v) {
                if ($v['gc_parent_id'] == $parent_id) {
                    //判断是否有子类
                    if (isset($tmp_list[$k + 1]['deep']) && $tmp_list[$k + 1]['deep'] > $v['deep']) {
                        $v['have_child'] = 1;
                    }
                    $class_list[] = $v;
                }
            }
        }

        if (input('param.ajax') == '1') {
            $output = json_encode($class_list);
            echo $output;
            exit;
        } else {
            $this->assign('class_list', $class_list);
            $this->setAdminCurItem('goods_class');
            return $this->fetch('goods_class');
        }
    }

    /**
     * 商品分类添加
     */
    public function goods_class_add() {
        $goodsclass_model = model('goodsclass');
        if (!request()->isPost()) {
            //父类列表，只取到第二级
            $parent_list = $goodsclass_model->getTreeClassList(2);
            $gc_list = array();
            if (is_array($parent_list)) {
                foreach ($parent_list as $k => $v) {
                    $parent_list[$k]['gc_name'] = str_repeat("&nbsp;", $v['deep'] * 2) . $v['gc_name'];
                    if ($v['deep'] == 1)
                        $gc_list[$k] = $v;
                }
            }
            $this->assign('gc_list', $gc_list);
            $this->assign('gc_parent_id', input('get.gc_parent_id'));
            $this->assign('parent_list', $parent_list);
            $this->setAdminCurItem('goods_class_add');
            return $this->fetch('goods_class_add');
        } else {

            $insert_array = array();
            $insert_array['gc_name'] = input('post.gc_name');
            $insert_array['gc_parent_id'] = intval(input('post.gc_parent_id'));
            $insert_array['commis_rate'] = intval(input('post.commis_rate'));
            $insert_array['gc_sort'] = intval(input('post.gc_sort'));

            $goods_validate = validate('goods');
            if (!$goods_validate->scene('goods_class_add')->check($insert_array)) {
                $this->error($goods_validate->getError());
            }

            $result = $goodsclass_model->addGoodsclass($insert_array);
            if ($result) {
                
                    $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_COMMON;
                    if (!empty($_FILES['pic']['name'])) {//上传图片
                        $file = request()->file('pic');
                        $file->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file, 'category-pic-' . $result . '.jpg');
                    }
                
                $this->log(lang('ds_add').lang('goods_class_index_class') . '[' . input('post.gc_name') . ']', 1);
                $this->success(lang('ds_common_save_succ'));
            } else {
                $this->log(lang('ds_add').lang('goods_class_index_class') . '[' . input('post.gc_name') . ']', 0);
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    /**
     * 编辑
     */
    public function goods_class_edit() {
        $goodsclass_model = model('goodsclass');
        $gc_id = intval(input('param.gc_id'));

        if (!request()->isPost()) {
            $class_array = $goodsclass_model->getGoodsclassInfoById($gc_id);

            if (empty($class_array)) {
                $this->error(lang('goods_class_batch_edit_paramerror'));
            }

            //父类列表，只取到第二级
            $parent_list = $goodsclass_model->getTreeClassList(2);
            if (is_array($parent_list)) {
                foreach ($parent_list as $k => $v) {
                    $parent_list[$k]['gc_name'] = str_repeat("&nbsp;", $v['deep'] * 2) . $v['gc_name'];
                }
            }
            $this->assign('parent_list', $parent_list);
            // 一级分类列表
            $gc_list = model('goodsclass')->getGoodsclassListByParentId(0);
            $this->assign('gc_list', $gc_list);


            $pic_name = BASE_UPLOAD_PATH . '/' . ATTACH_COMMON . '/category-pic-' . $class_array['gc_id'] . '.jpg';
            if (file_exists($pic_name)) {
                $class_array['pic'] = UPLOAD_SITE_URL . '/' . ATTACH_COMMON . '/category-pic-' . $class_array['gc_id'] . '.jpg';
            }


            $this->assign('class_array', $class_array);
            $this->setAdminCurItem('goods_class_edit');
            return $this->fetch('goods_class_edit');
        } else {


            $update_array = array();
            $update_array['gc_name'] = input('post.gc_name');
            $update_array['commis_rate'] = intval(input('post.commis_rate'));
            $update_array['gc_sort'] = intval(input('post.gc_sort'));
            $update_array['gc_parent_id'] = intval(input('post.gc_parent_id'));

            $goods_validate = validate('goods');
            if (!$goods_validate->scene('goods_class_edit')->check($update_array)) {
                $this->error($goods_validate->getError());
            }

            $parent_class=$goodsclass_model->getGoodsclassInfoById($update_array['gc_parent_id']);
            if($parent_class){
                if($parent_class['gc_parent_id']==$gc_id){
                    $this->error('父分类的父分类不能等于自身');
                }
            }
            if($update_array['gc_parent_id']==$gc_id){
                $this->error('父分类不能等于自身');
            }
            // 更新分类信息
            $where = array('gc_id' => $gc_id);
            $result = $goodsclass_model->editGoodsclass($update_array, $where);
            if ($result<0) {
                $this->log(lang('ds_edit').lang('goods_class_index_class') . '[' . input('post.gc_name') . ']', 0);
                $this->error(lang('goods_class_batch_edit_fail'));
            }

            if (!empty($_FILES['pic']['name'])) {//上传图片
                $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_COMMON;
                if (!empty($_FILES['pic']['name'])) {//上传图片
                    $file = request()->file('pic');
                    $file->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file, 'category-pic-' . $gc_id . '.jpg');
                }
            }

            // 检测是否需要关联自己操作，统一查询子分类
            if (input('post.t_commis_rate') == '1' || input('post.t_associated') == '1') {
                $gc_id_list = $goodsclass_model->getChildClass($gc_id);
                $gc_ids = array();
                if (is_array($gc_id_list) && !empty($gc_id_list)) {
                    foreach ($gc_id_list as $val) {
                        $gc_ids[] = $val['gc_id'];
                    }
                }
            }

            // 更新该分类下子分类的所有分佣比例
            if (input('post.t_commis_rate') == '1' && !empty($gc_ids)) {
                $goodsclass_model->editGoodsclass(array('commis_rate' => $update_array['commis_rate']), array('gc_id' => array('in', $gc_ids)));
            }


            $this->log(lang('ds_edit').lang('goods_class_index_class') . '[' . input('post.gc_name') . ']', 1);
            $this->success(lang('goods_class_batch_edit_ok'), url('Goodsclass/goods_class'));
        }
    }

    /**
     * 删除分类
     */
    public function goods_class_del() {
        $gc_id = input('param.gc_id');
        $gc_id_array = ds_delete_param($gc_id);
        if ($gc_id_array === FALSE) {
            $this->log(lang('ds_del').lang('goods_class_index_class') . '[ID:' . $gc_id . ']', 0);
            ds_json_encode('10001', lang('param_error'));
        }
        $goodsclass_model = model('goodsclass');
        //删除分类
        $goodsclass_model->delGoodsclassByGcIdString($gc_id);
        $this->log(lang('ds_del') . lang('goods_class_index_class') . '[ID:' . $gc_id . ']', 1);
        ds_json_encode('10000', lang('ds_common_del_succ'));
    }


    /**
     * ajax操作
     */
    public function ajax() {
        $branch = input('param.branch');

        switch ($branch) {
            /**
             * 更新分类
             */
            case 'goods_class_name':
                $goodsclass_model = model('goodsclass');
                $class_array = $goodsclass_model->getGoodsclassInfoById(intval(input('param.id')));
                
                $condition['gc_name'] = trim(input('param.value'));
                $condition['gc_parent_id'] = $class_array['gc_parent_id'];
                $condition['gc_id'] = array('neq',intval(input('param.id')));
                $class_list = $goodsclass_model->getGoodsclassList($condition);
                
                if (empty($class_list)) {
                    $where = array('gc_id' => intval(input('param.id')));
                    $update_array = array();
                    $update_array['gc_name'] = trim(input('param.value'));
                    $goodsclass_model->editGoodsclass($update_array, $where);
                    echo 'true';
                    exit;
                } else {
                    echo 'false';
                    exit;
                }
                break;
            /**
             * 分类 排序 显示 设置
             */
            case 'goods_class_sort':
            case 'goods_class_show':
            case 'goods_class_index_show':
                $goodsclass_model = model('goodsclass');
                $where = array('gc_id' => intval(input('param.id')));
                $update_array = array();
                $update_array[input('param.column')] = input('param.value');
                $goodsclass_model->editGoodsclass($update_array, $where);
                echo 'true';
                exit;
                break;
            /**
             * 添加、修改操作中 检测类别名称是否有重复
             */
            case 'check_class_name':
                $goodsclass_model = model('goodsclass');
                $condition['gc_name'] = trim(input('get.gc_name'));
                $condition['gc_parent_id'] = intval(input('get.gc_parent_id'));
                $condition['gc_id'] = array('neq', intval(input('get.gc_id')));
                $class_list = $goodsclass_model->getGoodsclassList($condition);
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

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'goods_class',
                'text' => '管理',
                'url' => url('Goodsclass/goods_class')
            ),
        );
        if (request()->action() == 'goods_class_add' || request()->action() == 'goods_class') {
            $menu_array[] = array(
                'name' => 'goods_class_add',
                'text' => '新增',
                'url' => url('Goodsclass/goods_class_add')
            );
        }
        if (request()->action() == 'goods_class_edit') {
            $menu_array[] = array(
                'name' => 'goods_class_edit',
                'text' => '编辑',
                'url' => 'javascript:void(0)'
            );
        }
        return $menu_array;
    }

}

?>
