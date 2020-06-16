<?php

namespace app\mobile\controller;

class Product extends BaseMall
{
    public function _initialize()
    {
        parent::_initialize();
    }
    /**
     * 案例信息 - 案例栏目
     * @return mixed
     */
    public function search()
    {
        $product_model = model('product');
        $condition = array();
        $where = array();
        $productcolumn_id = intval(input('param.id'));
        if ($productcolumn_id > 0) {
            $condition['column_id'] = $productcolumn_id;
        }
        $key = 'product_list_' . $productcolumn_id . '_' . input('param.page');
        $product = rcache($key);
        if (!empty($product)) {
            $condition['product_displaytype'] = 1;
            $where['column_module'] = COLUMN_PRODUCT;
            $product['product_list'] = $product_model->getProductList($condition, '*', 6);
            $product['page'] = $product_model->page_info->render();
            $product['product_column_list'] = model('column')->getColumnList($where);
            wcache($key, $product, '', 36000);
        }
        $this->assign('product_list', $product['product_list']);
        $this->assign('page', $product['page']);
        $this->assign('product_column', $product['product_column_list']);
        return $this->fetch($this->template_dir . 'search');
    }

    /**
     * 案例详情页
     * @return mixed
     */
    public function detail()
    {
        $condition = array();
        $where = array();
        $product_id = intval(input('param.product_id'));
        if ($product_id <= 0) {
            $this->error('参数错误');
        }
        $product_model = model('product');
        $condition['product_id'] = $product_id;
        $product_info = $product_model->getOneProduct($condition);

        //获取案例列表
        $key = "productcolumn_list";
        $productcolumn_list = rcache($key);
        if (empty($productcolumn_list)) {
            $where['column_module'] = COLUMN_PRODUCT;
            $productcolumn_list = model('column')->getColumnList($where);
            wcache($key, $productcolumn_list, '', 36000);
        }
        $this->assign('product_column', $productcolumn_list);
        $this->assign('product_info', $product_info);
        return $this->fetch($this->template_dir . 'detail');
    }

}
