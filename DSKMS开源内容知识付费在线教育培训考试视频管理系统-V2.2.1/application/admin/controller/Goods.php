<?php

/**
 * 商品管理
 */

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
class  Goods extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/goods.lang.php');
    }

    /**
     * 商品管理
     */
    public function index() {
        $goods_model = model('goods');
        /**
         * 处理商品分类
         */
        $choose_gcid = ($t = intval(input('param.choose_gcid'))) > 0 ? $t : 0;
        $gccache_arr = model('goodsclass')->getGoodsclassCache($choose_gcid, 3);
        $this->assign('gc_json', json_encode($gccache_arr['showclass']));
        $this->assign('gc_choose_json', json_encode($gccache_arr['choose_gcid']));

        /**
         * 查询条件
         */
        $where = array();
        $search_goods_name = trim(input('param.search_goods_name'));
        if ($search_goods_name != '') {
            $where['goods_name'] = array('like', '%' . $search_goods_name . '%');
        }
        $search_goods_id = intval(input('param.search_goods_id'));
        if ($search_goods_id > 0) {
            $where['goods_id'] = $search_goods_id;
        }
        $search_store_name = trim(input('param.search_store_name'));
        if ($search_store_name != '') {
            $where['store_name'] = array('like', '%' .$search_store_name . '%');
        }
        if ($choose_gcid > 0) {
            $where['gc_id_' . ($gccache_arr['showclass'][$choose_gcid]['depth'])] = $choose_gcid;
        }
        $goods_state = input('param.goods_state');
        if (in_array($goods_state, array('0', '1', '10'))) {
            $where['goods_state'] = $goods_state;
        }
        $goods_verify = input('param.goods_verify');
        if (in_array($goods_verify, array('0', '1', '10'))) {
            $where['goods_verify'] = $goods_verify;
        }

        $type = input('param.type');
        switch ($type) {
            // 禁售
            case 'lockup':
                $goods_list = $goods_model->getGoodsLockUpList($where);
                break;
            // 等待审核
            case 'waitverify':
                $goods_list = $goods_model->getGoodsWaitVerifyList($where, '*', 10, 'goods_verify desc, goods_id desc');
                break;
            // 全部商品
            default:
                $goods_list = $goods_model->getGoodsList($where, '*', 10);
                break;
        }

        $this->assign('goods_list', $goods_list);
        $this->assign('show_page', $goods_model->page_info->render());

        $this->assign('search', $where);

        $this->assign('state', array('1' => '出售中', '0' => '仓库中', '10' => '违规下架'));

        $this->assign('verify', array('1' => '通过', '0' => '未通过', '10' => '等待审核'));

        $this->assign('ownShopIds', array_fill_keys(model('store')->getOwnShopIds(), true));

        $type = input('param.type');
        if(!in_array($type, array('lockup','waitverify','allgoods'))){
            $type = 'allgoods';
        }
        
        $this->assign('type', $type);
        $this->setAdminCurItem($type);
        return $this->fetch();
    }



    /**
     * 违规下架
     */
    public function goods_lockup() {
        if (request()->isPost()) {
            $goods_ids = input('param.goods_ids');
            $goods_id_array = ds_delete_param($goods_ids);
            if ($goods_id_array == FALSE) {
                $this->error(lang('ds_common_op_fail'));
            }
            
            $update = array();
            $update['goods_stateremark'] = trim(input('post.close_reason'));

            $where = array();
            $where['goods_id'] = array('in', $goods_id_array);

            model('goods')->editProducesLockUp($update, $where);
            dsLayerOpenSuccess(lang('ds_common_op_succ'));
        } else {
            $this->assign('goods_ids', input('param.goods_id'));
            echo $this->fetch('close_remark');
        }
    }

    /**
     * 删除商品
     */
    public function goods_del() {
        $goods_id = input('param.goods_id');
        $goods_id_array = ds_delete_param($goods_id);
        if ($goods_id_array == FALSE) {
            ds_json_encode('10001', lang('ds_common_op_fail'));
        }
        $condition = array();
        $condition['goods_id'] = array('in',$goods_id_array);
        model('goods')->delGoodsAll($condition);
        ds_json_encode('10000', lang('ds_common_op_succ'));
    }

    /**
     * 审核商品
     */
    public function goods_verify() {
        if (request()->isPost()) {
            $goods_ids = input('param.goods_ids');
            $goods_id_array = ds_delete_param($goods_ids);
            if ($goods_id_array == FALSE) {
                $this->error(lang('ds_common_op_fail'));
            }

            $update2 = array();
            $update2['goods_verify'] = intval(input('param.verify_state'));

            $update1 = array();
            $update1['goods_verifyremark'] = trim(input('param.verify_reason'));
            $update1 = array_merge($update1, $update2);
            $where = array();
            $where['goods_id'] = array('in', $goods_id_array);

            $goods_model = model('goods');
            if (intval(input('param.verify_state')) == 0) {
                $goods_model->editProducesVerifyFail($where, $update1, $update2);
            } else {
                $goods_model->editProduces($where, $update1, $update2);
            }
            dsLayerOpenSuccess(lang('ds_common_op_succ'));
        } else {
            $this->assign('goods_ids', input('param.goods_id'));
            echo $this->fetch('verify_remark');
        }
    }

    //ajax获取同一个goods_id下面的商品信息
    public function get_goods_list_ajax() {
        $goods_id = input('param.goods_id');
        if (empty($goods_id)) {
            $this->error(lang('param_error'));
        }
        $map['goods_id'] = $goods_id;
        $goods_model = model('goods');
        $common_info = $goods_model->getGoodsInfo($map,'spec_name');
        return json_encode($goods_list);
    }
    /**
     * ajax操作
     */
    public function ajax() {
        $goods_model = model('goods');
        switch (input('param.branch')) {
            case 'mall_goods_commend':
            case 'mall_goods_sort':
                if (empty($result)) {
                    $goods_model->editGoodsById(array(trim(input('param.branch')) => trim(input('param.value'))),array(intval(input('param.id'))));
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
                'name' => 'allgoods',
                'text' => '所有商品',
                'url' => url('Goods/index')
            ),
            array(
                'name' => 'lockup',
                'text' => '下架商品',
                'url' => url('Goods/index', ['type' => 'lockup'])
            ),
            array(
                'name' => 'waitverify',
                'text' => '待审核',
                'url' => url('Goods/index', ['type' => 'waitverify'])
            ),
        );
        return $menu_array;
    }

}

?>
