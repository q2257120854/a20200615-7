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
class  Sellergoodsoffline extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellergoodsadd.lang.php');
        $this->template_dir = 'default/seller/sellergoodsadd/';
    }

    public function index() {
        $this->goods_storage();
    }

    /**
     * 仓库中的商品列表
     */
    public function goods_storage() {
        $goods_model = model('goods');

        $where = array();
        $where['store_id'] = session('store_id');

        $storegc_id = intval(input('get.storegc_id'));
        if ($storegc_id > 0) {
            $where['goods_stcids'] = array('like', '%,' . $storegc_id . ',%');
        }
        $keyword = input('get.keyword');
        $search_type = input('get.search_type');
        if (trim($keyword) != '') {
            switch ($search_type) {
                case 0:
                    $where['goods_name'] = array('like', '%' . trim($keyword) . '%');
                    break;
                case 1:
                    $where['goods_serial'] = array('like', '%' . trim($keyword) . '%');
                    break;
                case 2:
                    $where['goods_id'] = intval($keyword);
                    break;
            }
        }

        $type = input('param.type');
        $verify = input('get.verify');
        switch ($type) {
            // 违规的商品
            case 'lock_up':
                /* 设置卖家当前菜单 */
                $this->setSellerCurMenu('sellergoodsoffline');
                $this->setSellerCurItem('goods_lockup');
                $goods_list = $goods_model->getGoodsLockUpList($where);
                break;
            // 等待审核或审核失败的商品
            case 'wait_verify':
                /* 设置卖家当前菜单 */
                $this->setSellerCurMenu('sellergoodsoffline');
                $this->setSellerCurItem('goods_verify');
                if (isset($verify) && in_array($verify, array('0', '10'))) {
                    $where['goods_verify'] = $verify;
                }
                $goods_list = $goods_model->getGoodsWaitVerifyList($where);
                break;
            // 仓库中的商品
            default:
                /* 设置卖家当前菜单 */
                $this->setSellerCurMenu('sellergoodsoffline');
                $this->setSellerCurItem('goods_storage');
                $goods_list = $goods_model->getGoodsOfflineList($where);
                break;
        }

        $this->assign('show_page', $goods_model->page_info->render());
        $this->assign('goods_list', $goods_list);


        // 商品分类
        $store_goods_class = model('storegoodsclass')->getClassTree(array('store_id' => session('store_id'), 'storegc_state' => '1'));
        $this->assign('store_goods_class', $store_goods_class);

        switch ($type) {
            // 违规的商品
            case 'lock_up':
                echo $this->fetch($this->template_dir.'store_goods_list_offline_lockup');
                break;
            // 等待审核或审核失败的商品
            case 'wait_verify':
                $this->assign('verify', array('0' => '未通过', '10' => '等待审核'));
                echo $this->fetch($this->template_dir.'store_goods_list_offline_waitverify');
                break;
            // 仓库中的商品
            default:
                echo $this->fetch($this->template_dir.'store_goods_list_offline');
                break;
        }
        exit;
    }

    /**
     * 商品上架
     */
    public function goods_show() {
        $goods_id = input('param.goods_id');
        if (!preg_match('/^[\d,]+$/i', $goods_id)) {
            ds_json_encode(10001,lang('param_error'));
        }
        $goods_id_array = explode(',', $goods_id);
        if ($this->store_info['store_state'] != 1) {
            ds_json_encode(10001,lang(lang('store_goods_index_goods_show_fail') . '，机构正在审核中或已经关闭'));
        }
        $return = model('goods')->editProducesOnline(array('goods_id' => array('in', $goods_id_array), 'store_id' => session('store_id')));
        if ($return) {
            // 添加操作日志
            $this->recordSellerlog('商品上架，平台货号：' . $goods_id);
            ds_json_encode(10000,lang('store_goods_index_goods_show_success'));
        } else {
            ds_json_encode(10001,lang('store_goods_index_goods_show_fail'));
        }
    }

    /**
     *    栏目菜单
     */
    function getSellerItemList() {
        $item_list = array(
            array(
                'name' => 'goods_storage',
                'text' => lang('ds_member_path_goods_storage'),
                'url' => url('Sellergoodsoffline/index'),
            ),
            array(
                'name' => 'goods_lockup',
                'text' => lang('ds_member_path_goods_state'),
                'url' => url('Sellergoodsoffline/index', ['type' => 'lock_up']),
            ),
            array(
                'name' => 'goods_verify',
                'text' => lang('ds_member_path_goods_verify'),
                'url' => url('Sellergoodsoffline/index', ['type' => 'wait_verify']),
            ),
        );
        return $item_list;
    }

}

?>
