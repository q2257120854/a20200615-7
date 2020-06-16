<?php

namespace app\admin\controller;


use think\Lang;

class Product extends AdminControl
{
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/product.lang.php');
    }

    /**
     * 产品管理
     * @return type
     */
    public function index()
    {
        $model_product = Model('product');
        $condition = array();
        $product_list = $model_product->getProductList($condition,'*',5);

        $this->assign('show_page', $model_product->page_info->render());
        $this->assign('product_list', $product_list);
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 新增产品
     * @return type
     */
    public function add()
    {
        if (request()->isPost()) {
            $column_id = input('post.column_id');
            $data = array(
                'product_title' => input('post.product_title'),
                'seo_title' => input('post.seo_title'),
                'seo_keywords' => input('post.seo_keywords'),
                'seo_description' => input('post.seo_description'),
                'product_content' => input('post.product_content'),
                'product_order' => input('post.product_order'),
                'product_wap_ok' => input('post.product_wap_ok') ? 1 : 0,
                'product_displaytype' => input('post.product_displaytype') ? 1 : 0,
                'product_issue' => $this->admin_info['admin_name'],
                'product_recycle' => PRODUCT_RECYCLE_OK,
                'column_id' => $column_id,
            );
            if (!input('param.product_addtime')) {
                $data['product_addtime'] = TIMESTAMP;
            } else {
                $data['product_addtime'] = strtotime(input('param.product_addtime'));
            }

            //上传文件保存路径
            $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_PRODUCT;
            if (!empty($_FILES['product_img']['name'])) {
                $file = request()->file('product_img');
                $info = $file->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
                if ($info) {
                    $data['product_imgurl'] = $info->getSaveName();//图片带路径
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            //验证器
            $product_validate = validate('product');

            if (!$product_validate->scene('add')->check($data)){
                $this->error($product_validate->getError());
            }
            $result = model('product')->addproduct($data);
            if ($result){
                $this->success(lang('add_succ'), url('product/index'));
            }
            $this->error(lang('add_fail'));
        } else {
            $product = array(
                'product_show' => 1,
                'product_addtime' => TIMESTAMP,
                'product_displaytype' => 1,
                'product_wap_ok' => 1,
                'column_id' => 0,
            );
            $column_list = model('column')->getColumnList(['column_module'=>COLUMN_PRODUCT]);
            $pic_list = model('pic')->getPicList(array('pic_id' => 0));
            $this->assign('product', $product);
            $this->assign('product_pic_type', ['pic_type' => 'product']);
            $this->assign('pic_list', $pic_list);
            $this->assign('column_list', $column_list);
            $this->setAdminCurItem('add');
            return $this->fetch('form');
        }
    }

    /**
     * 编辑产品
     * @return type
     */
    public function edit()
    {
        $product_id = intval(input('param.product_id'));
        if ($product_id <= 0) {
            $this->error('系统错误');
        }
        $product = model('product')->getOneProduct(['product_id' => $product_id]);
        if(empty($product)){
            $this->error('系统错误');
        }

        if (request()->isPost()) {
            $data = array(
                'product_title' => input('post.product_title'),
                'seo_title' => input('post.seo_title'),
                'seo_keywords' => input('post.seo_keywords'),
                'seo_description' => input('post.seo_description'),
                'product_content' => input('post.product_content'),
                'product_order' => input('post.product_order'),
                'product_imgurl' => input('post.product_imgurl'),
                'product_issue' => $this->admin_info['admin_name'],
                'column_id' =>  input('post.column_id'),
            );
            if (!input('param.product_updatetime')) {
                $data['product_updatetime'] = TIMESTAMP;
            } else {
                $data['product_updatetime'] = strtotime(input('param.product_updatetime'));
            }


            if (!empty($_FILES['product_img']['name'])) {
                //上传文件保存路径
                $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_PRODUCT;
                $file = request()->file('product_img');
                $info = $file->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
                if ($info) {
                    //还需删除原来图片
                    $product_img_ori = $product['product_imgurl'];
                    if ($product_img_ori) {
                        @unlink($upload_file . DS . $product_img_ori);
                    }
                    $data['product_imgurl'] = $info->getSaveName();//图片带路径
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            //验证器
            $product_validate = validate('product');

            if (!$product_validate->scene('edit')->check($data)){
                $this->error($product_validate->getError());
            }
            $result = model('product')->editproduct(['product_id' => $product_id], $data);
            if ($result >= 0) {
                $this->success(lang('edit_succ'), 'product/index');
            } else {
                $this->error(lang('edit_fail'));
            }
        } else {
            $condition['pic_type'] = 'product';
            $condition['pic_type_id'] = $product_id;
            $pic_list = model('pic')->getpicList($condition);
            $this->assign('pic_list', $pic_list);

            //获取当前帮助中心的内容
            $column_list = model('column')->getColumnList(['column_module'=>COLUMN_PRODUCT]);
            $this->assign('column_list', $column_list);
            $this->assign('product_pic_type', ['pic_type' => 'product']);
            $this->assign('product', $product);
            $this->setAdminCurItem('edit');
            return $this->fetch('form');
        }
    }

    /**
     * 删除产品
     */
    function del()
    {
        $product_id = intval(input('param.product_id'));
        if ($product_id) {
            $condition['product_id'] = $product_id;
            $result = model('product')->delproduct($condition);
            if ($result) {
                ds_json_encode(10000, lang('del_succ'));
            } else {
                ds_json_encode(10001, lang('del_fail'));
            }
        } else {
            ds_json_encode(10001, lang('param_error'));
        }
    }

    /**
     * ajax操作
     */
    function ajax()
    {
        $branch = input('param.branch');
        switch ($branch) {
            case 'product':
                $product_mod = model('product');
                $condition = array('product_id' => intval(input('param.id')));
                $update[input('param.column')] = input('param.value');
                $product_mod->editproduct($condition, $update);
                echo 'true';
        }
    }

    /**
     * 设置产品
     */
    function setproduct()
    {
        $product_type = input('param.product_type');
        $product_id = input('param.product_id');
        $res = model('product')->getOneProduct(['product_id' => $product_id], $product_type);
        $id = $res[$product_type] == 0 ? 1 : 0;
        $update[$product_type] = $id;
        $condition['product_id'] = $product_id;
        if (model('product')->editproduct($condition, $update)) {
            ds_json_encode(10000, lang('edit_succ'));
        } else {
            $this->error(lang('edit_fail'));
        }
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     * @return string
     */
    protected function getAdminItemList()
    {
        $menu_array = array(
            array(
                'name' => 'index', 'text' => '管理', 'url' => url('product/index')
            ), array(
                'name' => 'add', 'text' => '新增', 'url' => url('product/add')
            ),
        );
        if (request()->action() == 'edit') {
            $menu_array[] = array(
                'name' => 'edit', 'text' => '编辑', 'url' => url('product/edit')
            );
        }
        return $menu_array;
    }
}