<?php

namespace app\home\controller;

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
class  Store extends BaseStore {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/store.lang.php');
    }


    public function index() {

        $condition = array();
        $condition['store_id'] = $this->store_info['store_id'];

        $goods_model = model('goods'); // 字段
        $fieldstr = "goods_id,goods_name,goods_advword,store_id,store_name,goods_price,goods_image,goods_salenum,evaluation_good_star,evaluation_count";
        //得到最新12个商品列表
        $new_goods_list = $goods_model->getGoodsListByColorDistinct($condition, $fieldstr, 'goods_id desc', 12);

        $condition['goods_commend'] = 1;
        //得到12个推荐商品列表
        $recommended_goods_list = $goods_model->getGoodsListByColorDistinct($condition, $fieldstr, 'goods_id desc', 12);
        $this->assign('new_goods_list', $new_goods_list);
        $this->assign('recommended_goods_list', $recommended_goods_list);

        //幻灯片图片
        if ($this->store_info['store_slide'] != '' && $this->store_info['store_slide'] != ',,,,') {
            $this->assign('store_slide', explode(',', $this->store_info['store_slide']));
            $this->assign('store_slide_url', explode(',', $this->store_info['store_slide_url']));
        }

        $this->assign('page', 'index');
        return $this->fetch($this->template_dir . 'index');
    }

    public function article() {
        //判断是否为导航页面
        $storenavigation_model = model('storenavigation');
        $store_navigation_info = $storenavigation_model->getStorenavigationInfo(array('storenav_id' => intval(input('param.storenav_id'))));
        if (!empty($store_navigation_info) && is_array($store_navigation_info)) {
            $this->assign('store_navigation_info', $store_navigation_info);
            return $this->fetch($this->template_dir . 'article');
        }
    }

    /**
     * 全部商品
     */
    public function goods_all() {

        $condition = array();
        $condition['store_id'] = $this->store_info['store_id'];
        $inkeyword = trim(input('inkeyword'));
        if ($inkeyword != '') {
            $condition['goods_name'] = array('like', '%' . $inkeyword . '%');
        }

        // 排序
        $order = input('order');
        $order = $order == 1 ? 'asc' : 'desc';
        $key = trim(input('key'));
        switch ($key) {
            case '1':
                $order = 'goods_id ' . $order;
                break;
            case '2':
                $order = 'goods_price ' . $order;
                break;
            case '3':
                $order = 'goods_salenum ' . $order;
                break;
            case '4':
                $order = 'goods_collect ' . $order;
                break;
            case '5':
                $order = 'goods_click ' . $order;
                break;
            default:
                $order = 'goods_id desc';
                break;
        }

        //查询分类下的子分类
        $storegc_id = intval(input('storegc_id'));
        if ($storegc_id > 0) {
            $condition['goods_stcids'] = array('like', '%,' . $storegc_id . ',%');
        }

        $goods_model = model('goods');
        $fieldstr = "goods_id,goods_name,goods_advword,store_id,store_name,goods_price,goods_image,goods_salenum,evaluation_good_star,evaluation_count";

        $recommended_goods_list = $goods_model->getGoodsListByColorDistinct($condition, $fieldstr, $order, 24);
        $this->assign('recommended_goods_list', $recommended_goods_list);
        
        /* 引用搜索相关函数 */
        require_once(APP_PATH . '/home/common_search.php');

        //输出分页
        $this->assign('show_page', empty($recommended_goods_list)?'':$goods_model->page_info->render());
        $stc_class = model('storegoodsclass');
        $stc_info = $stc_class->getStoregoodsclassInfo(array('storegc_id' => $storegc_id));
        $this->assign('storegc_name', $stc_info['storegc_name']);
        $this->assign('page', 'index');

        return $this->fetch($this->template_dir .'goods_list');
    }

}
