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
class  Sellerorder extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/' . config('default_lang') . '/sellerorder.lang.php');
    }

    /**
     * 订单列表
     *
     */
    public function index() {
        $order_model = model('order');
        $condition = array();
        $condition['store_id'] = session('store_id');

        $order_sn = input('get.order_sn');
        if ($order_sn != '') {
            $condition['order_sn'] = $order_sn;
        }
        $buyer_name = input('get.buyer_name');
        if ($buyer_name != '') {
            $condition['buyer_name'] = $buyer_name;
        }
        $allow_state_array = array('state_new', 'state_pay', 'state_send', 'state_pick', 'state_success', 'state_cancel');
        $state_type = input('param.state_type');
        if (in_array($state_type, $allow_state_array)) {
            $condition['order_state'] = str_replace($allow_state_array, array(ORDER_STATE_NEW, ORDER_STATE_PAY, ORDER_STATE_SEND, ORDER_STATE_DELIVER, ORDER_STATE_SUCCESS, ORDER_STATE_CANCEL), $state_type);
        } else {
            $state_type = 'store_order';
        }
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', input('get.query_start_date'));
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', input('get.query_end_date'));
        $start_unixtime = $if_start_date ? strtotime(input('get.query_start_date')) : null;
        $end_unixtime = $if_end_date ? strtotime(input('get.query_end_date')) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition['add_time'] = array('between', array($start_unixtime, $end_unixtime));
        }

        $skip_off = input('get.buyer_name');
        if ($skip_off == 1) {
            $condition['order_state'] = array('neq', ORDER_STATE_CANCEL);
        }

        $order_list = $order_model->getOrderList($condition, 10, '*', 'order_id desc', '', array('order_goods', 'order_common', 'member'));
        $this->assign('show_page', $order_model->page_info->render());

        //页面中显示那些操作
        foreach ($order_list as $key => $order_info) {
            //显示取消订单
            $order_info['if_cancel'] = $order_model->getOrderOperateState('store_cancel', $order_info);
            //显示调整运费
            $order_info['if_modify_price'] = $order_model->getOrderOperateState('modify_price', $order_info);
            //显示修改价格
            $order_info['if_spay_price'] = $order_model->getOrderOperateState('spay_price', $order_info);

            //显示锁定中
            $order_info['if_lock'] = $order_model->getOrderOperateState('lock', $order_info);

            //显示接单
            $order_info['if_receipt'] = $order_model->getOrderOperateState('receipt', $order_info);

            //显示派单
            $order_info['if_deliver'] = $order_model->getOrderOperateState('deliver', $order_info);

            foreach ($order_info['extend_order_goods'] as $value) {
                $value['image_240_url'] = goods_cthumb($value['goods_image'], 240, $value['store_id']);
                $value['goods_type_cn'] = get_order_goodstype($value['goods_type']);
                $value['goods_url'] = url('Goods/index', ['goods_id' => $value['goods_id']]);
                if ($value['goods_type'] == 5) {
                    $order_info['zengpin_list'][] = $value;
                } else {
                    $order_info['goods_list'][] = $value;
                }
            }

            if (empty($order_info['zengpin_list'])) {
                $order_info['goods_count'] = count($order_info['goods_list']);
            } else {
                $order_info['goods_count'] = count($order_info['goods_list']) + 1;
            }
            $order_list[$key] = $order_info;
        }

        $this->assign('order_list', $order_list);


        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellerorder');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem($state_type);
        return $this->fetch($this->template_dir . 'index');
    }

    /*
     * 指派订单
     */

    public function deliver_order() {
        $order_id = intval(input('post.order_id'));
        $o2o_distributor_id = intval(input('post.o2o_distributor_id'));
        if (!$order_id || !$o2o_distributor_id) {
            ds_json_encode(10001, lang('param_error'));
        }

        $order_model = model('order');
        $o2o_distributor_notice_model = model('o2o_distributor_notice');
        $o2o_distributor_model = model('o2o_distributor');
        $o2o_distributor_info = $o2o_distributor_model->getO2oDistributorInfo(array('o2o_distributor_id' => $o2o_distributor_id, 'o2o_distributor_state' => 1));
        if (!$o2o_distributor_info) {
            ds_json_encode(10001, lang('seller_order_distributor_not_exist'));
        }
        $order_info = $order_model->getOrderInfo(array('order_id' => $order_id, 'store_id' => session('store_id'), 'order_state' => ORDER_STATE_RECEIPT, 'refund_state' => 0, 'lock_state' => 0,));
        if (!$order_info) {
            ds_json_encode(10001, lang('store_order_none_exist'));
        }
        $order_model->startTrans();
        try {
            $update_order = array();
            $update_order['o2o_distributor_id'] = $o2o_distributor_info['o2o_distributor_id'];
            $update_order['o2o_distributor_name'] = $o2o_distributor_info['o2o_distributor_name'];
            $update_order['o2o_distributor_realname'] = $o2o_distributor_info['o2o_distributor_realname'];
            $update_order['o2o_distributor_phone'] = $o2o_distributor_info['o2o_distributor_phone'];
            $update_order['order_state'] = ORDER_STATE_DELIVER;
            $update_order['o2o_order_deliver_time'] = TIMESTAMP;
            $update_order['o2o_order_source'] = 2;
            $update = $order_model->editOrder($update_order, array(
                'order_id' => $order_info['order_id'], 'order_state' => ORDER_STATE_RECEIPT, 'refund_state' => 0, 'lock_state' => 0,
            ));
            if (!$update) {
                exception(lang('seller_order_edit_order_fail'));
            }


            $data = array();
            $data['order_id'] = $order_info['order_id'];
            $data['log_role'] = 'seller';
            $data['log_user'] = session('seller_name');
            $data['log_msg'] = '店铺派单给配送员' . $update_order['o2o_distributor_name'];
            $data['log_orderstate'] = ORDER_STATE_DELIVER;
            $order_model->addOrderlog($data);


            //生成订单通知
            $o2o_distributor_notice_model->addO2oDistributorNotice(array(
                'o2o_distributor_id' => $update_order['o2o_distributor_id'],
                'o2o_distributor_name' => $update_order['o2o_distributor_name'],
                'o2o_distributor_notice_type' => 1,
                'order_id' => $order_info['order_id'],
                'o2o_distributor_notice_title' => lang('ds_o2o_distributor_notice_type_text')[1],
                'o2o_distributor_notice_content' => sprintf(lang('seller_order_deliver_order_notice'), $order_info['order_sn']),
                'o2o_distributor_notice_add_time' => TIMESTAMP,
            ));
            $order_model->commit();
        } catch (\Exception $e) {

            $order_model->rollback();
            ds_json_encode(10001, $e->getMessage());
        }
        
        $openid = db('member')->where(array('member_id' => $order_info['buyer_id']))->value('member_wxopenid');
            if ($openid && config('wechat_tm_order_receipt')) {
                $tm_data = array(
                    "first" => array(
                        "value" => lang('wechat_tm_order_receipt'),
                        "color" => "#ff7007"
                    ),
                    "keyword1" => array(
                        "value" => $order_info['order_sn'],
                        "color" => "#333"
                    ),
                    "keyword2" => array(
                        "value" => date('Y-m-d H:i:s'),
                        "color" => "#333"
                    ),
                    "remark" => array(
                        "value" => lang('order_state_receipt_notice'),
                        "color" => "#333"
                    )
                );
                \mall\queue\QueueClient::push('sendWechatTemplateMessage', array(
                    'openid' => $openid,
                    'template_id' => config('wechat_tm_order_receipt'),
                    'url' => config('h5_site_url') . '/member/order_detail?order_id=' . $order_info['order_id'],
                    'data' => $tm_data,
                ));
            }
        $order_info = array_merge($order_info, $update_order);
        $order_info = $order_model->formatO2oOrder($this->store_info, $order_info);
        ds_json_encode(10000, lang('ds_common_op_succ'), array('order_info' => $order_info));
    }

    /*
     * 查看配送员
     */

    public function show_distributor() {
        $order_id = intval(input('param.order_id'));
        if ($order_id <= 0) {
            $this->error(lang('param_error'));
        }

        $order_model = model('order');
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['order_state'] = ORDER_STATE_RECEIPT;
        $condition['store_id'] = session('store_id');
        $temp = $order_model->getOrderInfo($condition, array('order_common'));
        if (empty($temp)) {
            $this->error(lang('store_order_none_exist'));
        }
        $order_info=array(
            'order_type'=>'real_order',
            'order_id'=>$temp['order_id'],
            'order_sn'=>$temp['order_sn'],
            'reciver_name'=>$temp['extend_order_common']['reciver_name'],
            'reciver_address'=>$temp['extend_order_common']['reciver_info']['address'],
            'reciver_phone'=>$temp['extend_order_common']['reciver_info']['mob_phone'],
            'order_distance'=>$temp['o2o_order_distance'],
            'order_lng'=>$temp['o2o_order_lng'],
            'order_lat'=>$temp['o2o_order_lat'],
        );
        if(!$this->store_info['store_longitude'] || !$this->store_info['store_latitude']){
            $this->error('请先设置店铺地图',url('sellersetting/map'));
        }
        //$this->assign('o2o_distributor_list', $o2o_distributor_list);
        $this->assign('o2o_socket_url', config('o2o_socket_url'));
        $this->assign('baidu_ak', config('baidu_ak'));
        $this->assign('order_info', $order_info);
        $this->assign('store_longitude', $this->store_info['store_longitude']);
        $this->assign('store_latitude', $this->store_info['store_latitude']);

        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellerorder');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem();
        return $this->fetch($this->template_dir . 'show_distributor');
    }

    /*
     * 配送员列表
     */

    public function get_distributor_list() {
        $order_id = intval(input('param.order_id'));
        if ($order_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }
        $order_model = model('order');
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['order_state'] = ORDER_STATE_RECEIPT;
        $condition['store_id'] = session('store_id');
        $order_info = $order_model->getOrderInfo($condition, array('order_common'));
        if (empty($order_info)) {
            ds_json_encode(10001, lang('store_order_none_exist'));
        }
        //配送员列表
        $o2o_distributor_model = model('o2o_distributor');
        $conditions = array('o2o_distributor_state' => 1);
        if ($order_info['o2o_order_distributor_type'] == 1) {
            $conditions['store_id'] = session('store_id');
        } else {
            $conditions['store_id'] = 0;
            $conditions['o2o_distributor_region_id'] = $this->store_info['region_id'];
        }
        $o2o_distributor_list = $o2o_distributor_model->getO2oDistributorList($conditions, '*', 10);
        foreach ($o2o_distributor_list as $key => $val) {
            $o2o_distributor_list[$key]['o2o_distributor_avatar'] = get_o2o_distributor_file($val['o2o_distributor_avatar'],'avatar');
            $o2o_distributor_list[$key]['count_wait'] = $order_model->getOrderCount(array('o2o_order_deliver_time' => array('>', strtotime(date('Y-m-d 0:0:0'))), 'o2o_distributor_id' => $val['o2o_distributor_id'], 'order_state' => array('in', [ORDER_STATE_DELIVER, ORDER_STATE_SEND])));
            $o2o_distributor_list[$key]['count_complete'] = $order_model->getOrderCount(array('o2o_order_deliver_time' => array('>', strtotime(date('Y-m-d 0:0:0'))), 'o2o_distributor_id' => $val['o2o_distributor_id'], 'order_state' => array('in', [ORDER_STATE_SUCCESS])));
        }
        ds_json_encode(10000, '', $o2o_distributor_list);
    }

    /*
     * 订单取货
     */

    public function check_o2o_order_pickup_code() {
        $o2o_order_pickup_code = input('post.o2o_order_pickup_code');
        if (!$o2o_order_pickup_code) {
            ds_json_encode(10001, lang('store_order_o2o_order_pickup_code_require'));
        }
        if (strlen($o2o_order_pickup_code) != 6) {
            ds_json_encode(10001, lang('store_order_o2o_order_pickup_code_length_error'));
        }
        $order_model = model('order');
        $order_info = $order_model->getOrderInfo(array('order_state' => ORDER_STATE_DELIVER, 'o2o_order_pickup_code' => $o2o_order_pickup_code, 'store_id' => session('store_id'), 'refund_state' => 0, 'lock_state' => 0,));
        if (empty($order_info)) {
            $this->error(lang('store_order_none_exist'));
        }
        ds_json_encode(10000, '', array('order_id' => $order_info['order_id'], 'o2o_order_pickup_code' => $o2o_order_pickup_code));
    }

    /*
     * 接收订单
     */

    public function receipt_order() {
        $order_id = intval(input('param.order_id'));
        if ($order_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }

        $order_model = model('order');
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['order_state'] = ORDER_STATE_PAY;
        $condition['store_id'] = session('store_id');
        $order_info = $order_model->getOrderInfo($condition);
        if (empty($order_info)) {
            ds_json_encode(10001, lang('store_order_none_exist'));
        }
        $order_model->startTrans();
        try {
            $update_order = array();
            $o2o_order_pickup_code = makeO2oOrderPickupCode();
            if ($o2o_order_pickup_code === false) {
                exception(lang('seller_order_make_pickup_code_fail'));
            }
            $update_order['o2o_order_pickup_code'] = $o2o_order_pickup_code;
            $update_order['order_state'] = ORDER_STATE_RECEIPT;
            $update_order['o2o_order_receipt_time'] = TIMESTAMP;

            $update = $order_model->editOrder($update_order, array(
                'order_id' => $order_info['order_id'], 'order_state' => ORDER_STATE_PAY, 'refund_state' => 0, 'lock_state' => 0,
            ));
            if (!$update) {
                exception(lang('seller_order_edit_order_fail'));
            }
            $data = array();
            $data['order_id'] = $order_info['order_id'];
            $data['log_role'] = 'seller';
            $data['log_user'] = session('seller_name');
            $data['log_msg'] = '店铺手动接单';
            $data['log_orderstate'] = ORDER_STATE_RECEIPT;
            $order_model->addOrderlog($data);

            $order_model->commit();
        } catch (\Exception $e) {

            $order_model->rollback();
            ds_json_encode(10001, $e->getMessage());
        }
        ds_json_encode(10000, lang('ds_common_op_succ'));
    }
    
    /*
     * 拒绝订单
     */

    public function reject_order() {
        $order_id = intval(input('param.order_id'));
        if ($order_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }

        $order_model = model('order');
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['order_state'] = ORDER_STATE_PAY;
        $condition['store_id'] = session('store_id');
        $order_info = $order_model->getOrderInfo($condition);
        if (empty($order_info)) {
            ds_json_encode(10001, lang('store_order_none_exist'));
        }
        $order_model->startTrans();
        try {
            $refundreturn_model = model('refundreturn');
            $book_amount = $order_info['refund_amount'];//退款金额
            $allow_refund_amount = ds_price_format($order_info['order_amount'] - $book_amount);//可退款金额

            $refund_array = array();
            $refund_array['refund_type'] = '1';//类型:1为退款,2为退货
            $refund_array['seller_state'] = '2';//状态:1为待审核,2为同意,3为不同意
            $refund_array['order_lock'] = '2';//锁定类型:1为不用锁定,2为需要锁定
            $refund_array['goods_id'] = '0';
            $refund_array['order_goods_id'] = '0';
            $refund_array['reason_id'] = '0';
            $refund_array['reason_info'] = '店铺拒绝订单，订单退款';
            $refund_array['goods_name'] = '订单商品全部退款';
            $refund_array['refund_amount'] = ds_price_format($allow_refund_amount);
            $refund_array['buyer_message'] = '';
            $refund_array['add_time'] = TIMESTAMP;
            $refund_array['seller_time'] = TIMESTAMP;
            $refund_array['refund_state'] = '2';
            $refund_array['seller_message'] = input('post.reason');
            

            $state = $refundreturn_model->addRefundreturn($refund_array, $order_info);
            if ($state) {
                $refundreturn_model->editOrderLock($order_id);
            }
            else {
                ds_json_encode(10001,'退款申请保存失败');
            }

            $order_model->commit();
        } catch (\Exception $e) {

            $order_model->rollback();
            ds_json_encode(10001, $e->getMessage());
        }
        ds_json_encode(10000, lang('ds_common_op_succ'));
    }

    /**
     * 卖家订单详情
     *
     */
    public function show_order() {
        $order_id = intval(input('param.order_id'));
        if ($order_id <= 0) {
            $this->error(lang('param_error'));
        }
        $order_model = model('order');
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['store_id'] = session('store_id');
        $order_info = $order_model->getOrderInfo($condition, array('order_common', 'order_goods', 'member'));
        if (empty($order_info)) {
            $this->error(lang('store_order_none_exist'));
        }

        $refundreturn_model = model('refundreturn');
        $order_list = array();
        $order_list[$order_id] = $order_info;
        $order_list = $refundreturn_model->getGoodsRefundList($order_list, 1); //订单商品的退款退货显示
        $order_info = $order_list[$order_id];
        $refund_all = isset($order_info['refund_list'][0]) ? $order_info['refund_list'][0] : '';
        if (!empty($refund_all) && $refund_all['seller_state'] < 3) {//订单全部退款商家审核状态:1为待审核,2为同意,3为不同意
            $this->assign('refund_all', $refund_all);
        }

        //显示锁定中
        $order_info['if_lock'] = $order_model->getOrderOperateState('lock', $order_info);

        //显示调整运费
        $order_info['if_modify_price'] = $order_model->getOrderOperateState('modify_price', $order_info);

        //显示调整价格
        $order_info['if_spay_price'] = $order_model->getOrderOperateState('spay_price', $order_info);

        //显示取消订单
        $order_info['if_cancel'] = $order_model->getOrderOperateState('store_cancel', $order_info);

        //显示接单
        $order_info['if_receipt'] = $order_model->getOrderOperateState('receipt', $order_info);

        //显示派单
        $order_info['if_deliver'] = $order_model->getOrderOperateState('deliver', $order_info);

        //显示取货
        $order_info['if_pickup'] = (input('param.o2o_order_pickup_code') == $order_info['o2o_order_pickup_code']) ? $order_model->getOrderOperateState('pickup', $order_info) : false;

        //显示系统自动取消订单日期
        if ($order_info['order_state'] == ORDER_STATE_NEW) {
            $order_info['order_cancel_day'] = $order_info['add_time'] + config('order_auto_cancel_day') * 24 * 3600;
        }



        //显示系统自动收获时间
        if ($order_info['order_state'] == ORDER_STATE_SEND) {
            $order_info['order_confirm_day'] = $order_info['delay_time'] + config('order_auto_receive_day') * 24 * 3600;
        }

        //如果订单已取消，取得取消原因、时间，操作人
        if ($order_info['order_state'] == ORDER_STATE_CANCEL) {
            $order_info['close_info'] = $order_model->getOrderlogInfo(array('order_id' => $order_info['order_id']), 'log_id desc');
        }

        foreach ($order_info['extend_order_goods'] as $value) {
            $value['image_240_url'] = goods_cthumb($value['goods_image'], 240, $value['store_id']);
            $value['goods_type_cn'] = get_order_goodstype($value['goods_type']);
            $value['goods_url'] = url('Goods/index', ['goods_id' => $value['goods_id']]);
            if ($value['goods_type'] == 5) {
                $order_info['zengpin_list'][] = $value;
            } else {
                $order_info['goods_list'][] = $value;
            }
        }

        if (empty($order_info['zengpin_list'])) {
            $order_info['goods_count'] = count($order_info['goods_list']);
        } else {
            $order_info['goods_count'] = count($order_info['goods_list']) + 1;
        }

        $this->assign('order_info', $order_info);

        //发货信息
        if (!empty($order_info['extend_order_common']['daddress_id'])) {
            $daddress_info = model('daddress')->getAddressInfo(array('daddress_id' => $order_info['extend_order_common']['daddress_id']));
            $this->assign('daddress_info', $daddress_info);
        }
        $this->assign('o2o_socket_url', config('o2o_socket_url'));
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellerorder');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem();
        return $this->fetch($this->template_dir . 'show_order');
    }

    /**
     * 卖家订单状态操作
     *
     */
    public function change_state() {
        $state_type = input('param.state_type');
        $order_id = intval(input('param.order_id'));

        $order_model = model('order');
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['store_id'] = session('store_id');
        $order_info = $order_model->getOrderInfo($condition);
        if ($state_type == 'order_cancel') {
            $result = $this->_order_cancel($order_info, input('post.'));
        } elseif ($state_type == 'modify_price') {
            $result = $this->_order_ship_price($order_info, input('post.'));
        } elseif ($state_type == 'spay_price') {
            $result = $this->_order_spay_price($order_info, input('post.'));
        }
        if (!$result['code']) {
            ds_json_encode(10001, $result['msg']);
        } else {
            ds_json_encode(10000, $result['msg']);
        }
    }

    /*
     * 订单取货
     */

    public function pickup_order() {
        $order_model = model('order');
        $order_id = intval(input('param.order_id'));
        if ($order_id <= 0) {
            ds_json_encode(10001, lang('param_error'));
        }


        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['order_state'] = ORDER_STATE_DELIVER;
        $condition['store_id'] = session('store_id');
        $order_info = $order_model->getOrderInfo($condition);
        if (empty($order_info)) {
            ds_json_encode(10001, lang('store_order_none_exist'));
        }
        $order_model->startTrans();
        try {
            $update_order = array();
            $o2o_order_receive_code = makeO2oOrderReceiveCode();
            if ($o2o_order_receive_code === false) {
                exception(lang('seller_order_make_receive_code_fail'));
            }
            $update_order['o2o_order_receive_code'] = $o2o_order_receive_code;

            $update_order['order_state'] = ORDER_STATE_SEND;
            $update_order['o2o_order_pickup_time'] = TIMESTAMP;
            $update = $order_model->editOrder($update_order, array(
                'order_id' => $order_info['order_id'], 'order_state' => ORDER_STATE_DELIVER, 'refund_state' => 0, 'lock_state' => 0,
            ));
            if (!$update) {
                exception(lang('seller_order_edit_order_fail'));
            }
            $data = array();
            $data['order_id'] = $order_info['order_id'];
            $data['log_role'] = 'seller';
            $data['log_user'] = session('seller_name');
            $data['log_msg'] = '店铺确认配送员取货';
            $data['log_orderstate'] = ORDER_STATE_SEND;
            $order_model->addOrderlog($data);
            $order_model->commit();
        } catch (\Exception $e) {

            $order_model->rollback();
            ds_json_encode(10001, $e->getMessage());
        }
        $order_info = array_merge($order_info, $update_order);
        $order_info = $order_model->formatO2oOrder($this->store_info, $order_info);
        ds_json_encode(10000, lang('ds_common_op_succ'), array('order_info' => $order_info));
    }

    /**
     * 取消订单
     * @param unknown $order_info
     */
    private function _order_cancel($order_info, $post) {
        $order_model = model('order');
        $logic_order = model('order', 'logic');

        if (!request()->isPost()) {
            $this->assign('order_info', $order_info);
            $this->assign('order_id', $order_info['order_id']);
            echo $this->fetch($this->template_dir . 'cancel');
            exit();
        } else {
            $if_allow = $order_model->getOrderOperateState('store_cancel', $order_info);
            if (!$if_allow) {
                return ds_callback(false, '无权操作');
            }
            $msg = $post['state_info1'] != '' ? $post['state_info1'] : $post['state_info'];
            return $logic_order->changeOrderStateCancel($order_info, 'seller', session('member_name'), $msg);
        }
    }

    /**
     * 修改运费
     * @param unknown $order_info
     */
    private function _order_ship_price($order_info, $post) {
        $order_model = model('order');
        $logic_order = model('order', 'logic');
        if (!request()->isPost()) {
            $this->assign('order_info', $order_info);
            $this->assign('order_id', $order_info['order_id']);
            echo $this->fetch($this->template_dir . 'edit_price');
            exit();
        } else {
            $if_allow = $order_model->getOrderOperateState('modify_price', $order_info);
            if (!$if_allow) {
                return ds_callback(false, '无权操作');
            }
            return $logic_order->changeOrderShipPrice($order_info, 'seller', session('member_name'), $post['shipping_fee']);
        }
    }

    /**
     * 修改商品价格
     * @param unknown $order_info
     */
    private function _order_spay_price($order_info, $post) {
        $order_model = model('order');
        $logic_order = model('order', 'logic');
        if (!request()->isPost()) {
            $this->assign('order_info', $order_info);
            $this->assign('order_id', $order_info['order_id']);
            echo $this->fetch($this->template_dir . 'edit_spay_price');
            exit();
        } else {
            $if_allow = $order_model->getOrderOperateState('spay_price', $order_info);
            if (!$if_allow) {
                return ds_callback(false, '无权操作');
            }
            return $logic_order->changeOrderSpayPrice($order_info, 'seller', session('member_name'), $post['goods_amount']);
        }
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $menu_key 当前导航的menu_key
     * @return
     */
    function getSellerItemList() {
        $menu_array = array(
            array(
                'name' => 'store_order',
                'text' => lang('ds_member_path_all_order'),
                'url' => url('Sellerorder/index')
            ),
            array(
                'name' => 'state_new',
                'text' => lang('ds_member_path_wait_pay'),
                'url' => url('Sellerorder/index', ['state_type' => 'state_new'])
            ),
            array(
                'name' => 'state_pay',
                'text' => lang('ds_member_path_wait_send'),
                'url' => url('Sellerorder/index', ['state_type' => 'state_pay'])
            ),
            array(
                'name' => 'state_pick',
                'text' => lang('ds_member_path_pick'),
                'url' => url('Sellerorder/index', ['state_type' => 'state_pick'])
            ),
            array(
                'name' => 'state_send',
                'text' => lang('ds_member_path_sent'),
                'url' => url('Sellerorder/index', ['state_type' => 'state_send'])
            ),
            array(
                'name' => 'state_success',
                'text' => lang('ds_member_path_finished'),
                'url' => url('Sellerorder/index', ['state_type' => 'state_success'])
            ),
            array(
                'name' => 'state_cancel',
                'text' => lang('ds_member_path_canceled'),
                'url' => url('Sellerorder/index', ['state_type' => 'state_cancel'])
            ),
        );
        return $menu_array;
    }

}

?>
