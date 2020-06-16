<?php

namespace app\common\logic;

use think\Model;
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
 * 逻辑层模型
 */
class  Vrorder extends Model
{
    /**
     * 取消订单
     * @param array $order_info
     * @param string $role 操作角色 buyer、seller、admin、system 分别代表买家、机构、管理员、系统
     * @param string $msg 操作备注
     * @param boolean $if_queue 是否使用队列
     * @return array
     */
    public function changeOrderStateCancel($order_info, $role, $msg, $if_queue = true)
    {

        try {

            $vrorder_model = model('vrorder');
            $vrorder_model->startTrans();

            //库存、销量变更
            if ($if_queue) {
                \mall\queue\QueueClient::push('cancelOrderUpdateStorage', array($order_info['goods_id'] => $order_info['goods_num']));
            }
            else {
                \model('queue','logic')->cancelOrderUpdateStorage(array($order_info['goods_id'] => $order_info['goods_num']));
            }

            $predeposit_model = model('predeposit');

            //解冻充值卡
            $pd_amount = floatval($order_info['rcb_amount']);
            if ($pd_amount > 0) {
                $data_pd = array();
                $data_pd['member_id'] = $order_info['buyer_id'];
                $data_pd['member_name'] = $order_info['buyer_name'];
                $data_pd['amount'] = $pd_amount;
                $data_pd['order_sn'] = $order_info['order_sn'];
                $predeposit_model->changeRcb('order_cancel', $data_pd);
            }

            //解冻预存款
            $pd_amount = floatval($order_info['pd_amount']);
            if ($pd_amount > 0) {
                $data_pd = array();
                $data_pd['member_id'] = $order_info['buyer_id'];
                $data_pd['member_name'] = $order_info['buyer_name'];
                $data_pd['amount'] = $pd_amount;
                $data_pd['order_sn'] = $order_info['order_sn'];
                $predeposit_model->changePd('order_cancel', $data_pd);
            }

            //更新订单信息
            $update_order = array(
                'order_state' => ORDER_STATE_CANCEL, 'pd_amount' => 0, 'close_time' => TIMESTAMP, 'close_reason' => $msg
            );
            $update = $vrorder_model->editVrorder($update_order, array('order_id' => $order_info['order_id']));
            if (!$update) {
                exception('保存失败');
            }

            $vrorder_model->commit();
            return ds_callback(true, '更新成功');

        } catch (Exception $e) {
            $vrorder_model->rollback();
            return ds_callback(false, $e->getMessage());
        }
    }

    /**
     * 支付订单
     * @param array $order_info
     * @param string $role 操作角色 buyer、seller、admin、system 分别代表买家、机构、管理员、系统
     * @param string $post
     * @return array
     */
    public function changeOrderStatePay($order_info, $role, $post)
    {
        try {

            $vrorder_model = model('vrorder');
            $vrorder_model->startTrans();

            $predeposit_model = model('predeposit');
            //下单，支付被冻结的充值卡
            $rcb_amount = floatval($order_info['rcb_amount']);
            if ($rcb_amount > 0) {
                $data_pd = array();
                $data_pd['member_id'] = $order_info['buyer_id'];
                $data_pd['member_name'] = $order_info['buyer_name'];
                $data_pd['amount'] = $rcb_amount;
                $data_pd['order_sn'] = $order_info['order_sn'];
                $predeposit_model->changeRcb('order_comb_pay', $data_pd);
            }

            //下单，支付被冻结的预存款
            $pd_amount = floatval($order_info['pd_amount']);
            if ($pd_amount > 0) {
                $data_pd = array();
                $data_pd['member_id'] = $order_info['buyer_id'];
                $data_pd['member_name'] = $order_info['buyer_name'];
                $data_pd['amount'] = $pd_amount;
                $data_pd['order_sn'] = $order_info['order_sn'];
                $predeposit_model->changePd('order_comb_pay', $data_pd);
            }

            //更新订单状态
            $update_order = array();
            $update_order['order_state'] = ORDER_STATE_PAY;
            $update_order['payment_time'] = isset($post['payment_time']) ? strtotime($post['payment_time']) : TIMESTAMP;
            $update_order['payment_code'] = $post['payment_code'];
            $update_order['trade_no'] = $post['trade_no'];
            $update = $vrorder_model->editVrorder($update_order, array('order_id' => $order_info['order_id']));
            if (!$update) {
                exception(lang('ds_common_save_fail'));
            }
            
            // 支付成功发送买家消息
            $param = array();
            $param['code'] = 'order_payment_success';
            $param['member_id'] = $order_info['buyer_id'];
            $param['param'] = array(
                'order_sn' => $order_info['order_sn'],
                'order_url' => url('home/Membervrorder/show_order', array('order_id' => $order_info['order_id']))
            );
            //微信模板消息
                $param['weixin_param'] = array(
                    'url' => config('h5_site_url').'/member/vrorder_detail?order_id='.$order_info['order_id'],
                    'data'=>array(
                        "keyword1" => array(
                            "value" => $order_info['order_sn'],
                            "color" => "#333"
                        ),
                        "keyword2" => array(
                            "value" => $order_info['goods_name'],
                            "color" => "#333"
                        ),
                        "keyword3" => array(
                            "value" => $order_info['order_amount'],
                            "color" => "#333"
                        ),
                        "keyword4" => array(
                            "value" => date('Y-m-d H:i',$order_info['add_time']),
                            "color" => "#333"
                        )
                    ),
                );
            \mall\queue\QueueClient::push('sendMemberMsg', $param);

            // 支付成功发送机构消息
            $param = array();
            $param['code'] = 'new_order';
            $param['store_id'] = $order_info['store_id'];
            $param['param'] = array(
                'order_sn' => $order_info['order_sn']
            );
            $param['weixin_param']=array(
                    'url' => config('h5_site_url').'/seller/vrorder_detail?order_id='.$order_info['order_id'],
                    'data'=>array(
                        "keyword1" => array(
                            "value" => $order_info['order_sn'],
                            "color" => "#333"
                        ),
                        "keyword2" => array(
                            "value" => $order_info['goods_name'],
                            "color" => "#333"
                        ),
                        "keyword3" => array(
                            "value" => $order_info['order_amount'],
                            "color" => "#333"
                        ),
                        "keyword4" => array(
                            "value" => date('Y-m-d H:i',$order_info['add_time']),
                            "color" => "#333"
                        )
                    ),
                );
            \mall\queue\QueueClient::push('sendStoremsg', $param);


            $vrorder_model->commit();
            return ds_callback(true, '更新成功');

        } catch (Exception $e) {
            $vrorder_model->rollback();
            return ds_callback(false, $e->getMessage());
        }
    }

    /**
     * 完成订单
     * @param int $order_id
     * @return array
     */
    public function changeOrderStateSuccess($order_id)
    {
        $vrorder_model = model('vrorder');
        $condition = array();
        $condition['order_state'] = ORDER_STATE_PAY;
        $condition['refund_state'] = 0;
        $condition['order_id'] = $order_id;
        $order_info = $vrorder_model->getVrorderInfo($condition, '*');
        if (!empty($order_info)) {
            $update = $vrorder_model->editVrorder(array(
                                                     'order_state' => ORDER_STATE_SUCCESS, 'finnshed_time' => TIMESTAMP
                                                 ), array('order_id' => $order_id));
            if (!$update) {
                ds_callback(false, '更新失败');
            }
        }else{
            ds_callback(false, '系统错误');
        }

            
        //添加会员积分
        if (config('points_isuse') == 1) {
            model('points')->savePointslog('vrorder', array(
                'pl_memberid' => $order_info['buyer_id'], 'pl_membername' => $order_info['buyer_name'],
                'orderprice' => $order_info['order_amount'], 'order_sn' => $order_info['order_sn'],
                'order_id' => $order_info['order_id']
            ), true);
        }

        //添加会员经验值
        model('exppoints')->saveExppointslog('vrorder', array(
            'explog_memberid' => $order_info['buyer_id'], 'explog_membername' => $order_info['buyer_name'],
            'orderprice' => $order_info['order_amount'], 'order_sn' => $order_info['order_sn'],
            'order_id' => $order_info['order_id']
        ), true);

        return ds_callback(true, '更新成功');
    }
}