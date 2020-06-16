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
class  Seller extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/seller.lang.php');
    }

    /**
     * 商户中心首页
     *
     */
    public function index() {
        // 机构信息
        $store_info = $this->store_info;
        $store_info['reopen_tip'] = FALSE;
        if (intval($store_info['store_endtime']) > 0) {
            $store_info['store_endtime_text'] = date('Y-m-d', $store_info['store_endtime']);
            $reopen_time = $store_info['store_endtime'] - 3600 * 24 + 1 - TIMESTAMP;
            if (!session('is_platform_store') && $store_info['store_endtime'] - TIMESTAMP >= 0 && $reopen_time < 2592000) {
                //到期续签提醒(<30天)
                $store_info['reopen_tip'] = true;
            }
        } else {
            $store_info['store_endtime_text'] = lang('store_no_limit');
        }
        // 机构等级信息
        $store_info['grade_name'] = $this->store_grade['storegrade_name'];
        $store_info['grade_goodslimit'] = $this->store_grade['storegrade_goods_limit'];
        $store_info['grade_albumlimit'] = $this->store_grade['storegrade_album_limit'];

        $this->assign('store_info', $store_info);
        // 机构帮助
        $help_model = model('help');
        $condition = array();
        $condition['helptype_show'] = '1'; //是否显示,0为否,1为是
        $help_list = $help_model->getStoreHelptypeList($condition, '', 6);
        $this->assign('help_list', $help_list);


        
        if (!session('is_platform_store')) {
            if (config('voucher_allow') == 1) {
                $voucherquota_info = model('voucher')->getVoucherquotaCurrent(session('store_id'));
                $this->assign('voucherquota_info', $voucherquota_info);
            }
        } else {
            $this->assign('isPlatformStore', true);
        }
        $phone_array = explode(',', config('site_phone'));
        $this->assign('phone_array', $phone_array);

        $this->assign('menu_sign', 'index');


        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('seller_index');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem();
        return $this->fetch($this->template_dir.'index');
    }

    /**
     * 异步取得卖家统计类信息
     *
     */
    public function statistics() {
//        $add_time_to = strtotime(date("Y-m-d") + 60 * 60 * 24);   //当前日期 ,从零点来时
//        $add_time_from = strtotime(date("Y-m-d", (strtotime(date("Y-m-d")) - 60 * 60 * 24 * 30)));   //30天前
        $goods_online = 0;      // 出售中商品
        $goods_waitverify = 0;  // 等待审核
        $goods_verifyfail = 0;  // 审核失败
        $goods_offline = 0;     // 仓库待上架商品
        $goods_lockup = 0;      // 违规下架商品
        $consult = 0;           // 待回复商品咨询
        $no_payment = 0;        // 待付款
        $no_delivery = 0;       // 待发货
        $no_receipt = 0;        // 待收货

        $goods_model = model('goods');
        // 全部商品数
        $goodscount = $goods_model->getGoodsCount(array('store_id' => session('store_id')));
        // 出售中的商品
        $goods_online = $goods_model->getGoodsOnlineCount(array('store_id' => session('store_id')));
        if (config('goods_verify')) {
            // 等待审核的商品
            $goods_waitverify = $goods_model->getGoodsWaitVerifyCount(array('store_id' => session('store_id')));
            // 审核失败的商品
            $goods_verifyfail = $goods_model->getGoodsVerifyFailCount(array('store_id' => session('store_id')));
        }
        // 仓库待上架的商品
        $goods_offline = $goods_model->getGoodsOfflineCount(array('store_id' => session('store_id')));
        // 违规下架的商品
        $goods_lockup = $goods_model->getGoodsLockUpCount(array('store_id' => session('store_id')));
        // 等待回复商品咨询
        $consult = model('consult')->getConsultCount(array('store_id' => session('store_id'), 'consult_reply' => ''));

        // 商品图片数量
        $imagecount = model('album')->getAlbumpicCount(array('store_id' => session('store_id')));

        //待确认的结算账单
        $bill_model = model('bill');
        $condition = array();
        $condition['ob_store_id'] = session('store_id');
        $condition['ob_state'] = BILL_STATE_CREATE;
        $bill_confirm_count = $bill_model->getOrderbillCount($condition);

        //统计数组
        $statistics = array(
            'goodscount' => $goodscount,
            'online' => $goods_online,
            'waitverify' => $goods_waitverify,
            'verifyfail' => $goods_verifyfail,
            'offline' => $goods_offline,
            'lockup' => $goods_lockup,
            'imagecount' => $imagecount,
            'consult' => $consult,
            'bill_confirm' => $bill_confirm_count
        );
        exit(json_encode($statistics));
    }
}

?>
