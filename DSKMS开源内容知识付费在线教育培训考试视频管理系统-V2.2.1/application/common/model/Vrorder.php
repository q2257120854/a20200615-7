<?php

namespace app\common\model;

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
 * 数据层模型
 */
class  Vrorder extends Model {
    public $page_info;

    /**
     * 取单条订单信息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $fields 字段
     * @return type
     */
    public function getVrorderInfo($condition = array(), $fields = '*') {
        $order_info = db('vrorder')->field($fields)->where($condition)->find();
        if (empty($order_info)) {
            return array();
        }
        if (isset($order_info['order_state'])) {
            $state_desc = $this->_vrorderState($order_info['order_state']);
            $order_info['state_desc'] = $state_desc[0];
            $order_info['order_state_text'] = $state_desc[1];
        }
        if (isset($order_info['payment_code'])) {
            $order_info['payment_name'] = get_order_payment_name($order_info['payment_code']);
        }
        return $order_info;
    }

    /**
     * 新增订单
     * @access public
     * @author csdeshang
     * @param type $data 参数内容
     * @return type
     */
    public function addVrorder($data) {
        return db('vrorder')->insertGetId($data);
    }


    /**
     * 更改订单信息
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @param type $condition 条件
     * @param type $limit 限制
     * @return type
     */
    public function editVrorder($data, $condition, $limit = '') {
        return db('vrorder')->where($condition)->limit($limit)->update($data);
    }



    /**
     * 取得订单列表(所有)
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $pagesize 分页
     * @param type $field 字段
     * @param type $order 排序
     * @param type $limit 限制
     * @return type
     */
    public function getVrorderList($condition, $pagesize = '', $field = '*', $order = 'order_id desc', $limit = '') {
        if($pagesize){
            $list = db('vrorder')->field($field)->where($condition)->order($order)->limit($limit)->paginate($pagesize,false,['query' => request()->param()]);
            $this->page_info = $list;
            $list = $list->items();
        }else{
            $list = db('vrorder')->field($field)->where($condition)->order($order)->limit($limit)->select();
        }


        if (empty($list))
            return array();
        foreach ($list as $key => $order) {
            if (isset($order['order_state'])) {
                list($list[$key]['state_desc'], $list[$key]['order_state_text']) = $this->_vrorderState($order['order_state']);
            }
            if (isset($order['payment_code'])) {
                $list[$key]['payment_name'] = get_order_payment_name($order['payment_code']);
            }
        }

        return $list;
    }

    /**
     * 取得订单状态文字输出形式
     * @access public
     * @author csdeshang
     * @param type $order_state 订单状态
     * @return type
     */
    private function _vrorderState($order_state) {
        switch ($order_state) {
            case ORDER_STATE_CANCEL:
                $order_state = '<span style="color:#999">已取消</span>';
                $order_state_text = '已取消';
                break;
            case ORDER_STATE_NEW:
                $order_state = '<span style="color:#36C">待付款</span>';
                $order_state_text = '待付款';
                break;
            case ORDER_STATE_PAY:
                $order_state = '<span style="color:#999">已支付</span>';
                $order_state_text = '已支付';
                break;
            case ORDER_STATE_SUCCESS:
                $order_state = '<span style="color:#999">已完成</span>';
                $order_state_text = '已完成';
                break;
        }
        return array($order_state, $order_state_text);
        ;
    }

    /**
     * 返回是否允许某些操作
     * @access public
     * @author csdeshang
     * @param type $operate 操作
     * @param type $order_info 订单信息
     * @return boolean
     */
    public function getVrorderOperateState($operate, $order_info) {
        $state = false;
        if (!is_array($order_info) || empty($order_info))
            return false;

        switch ($operate) {

            //买家取消订单
            case 'buyer_cancel':
                $state = $order_info['order_state'] == ORDER_STATE_NEW;
                break;

            //机构取消订单
            case 'store_cancel':
                $state = $order_info['order_state'] == ORDER_STATE_NEW;
                break;

            //平台取消订单
            case 'system_cancel':
                $state = $order_info['order_state'] == ORDER_STATE_NEW;
                break;

            //平台收款
            case 'system_receive_pay':
                $state = $order_info['order_state'] == ORDER_STATE_NEW;
                break;

            //支付
            case 'payment':
                $state = $order_info['order_state'] == ORDER_STATE_NEW;
                break;

            //评价
            case 'evaluation':
                $state = !$order_info['refund_state'] && !isset($order_info['lock_state']) && $order_info['evaluation_state'] == '0' && $order_info['order_state'] == ORDER_STATE_SUCCESS;
                break;

            //买家退款
            case 'refund':
                //虚拟产品过期退款条件    未申请过退款,  已完成的订单不能申请退款，申请退款需要根据系统设置的允许退款周期内
                if (!$order_info['refund_state'] && $order_info['order_state'] == ORDER_STATE_PAY && ($order_info['payment_time'] + 60 * 60 * 24 * config('order_refund_time')) > TIMESTAMP) {
                    $state = true;
                }
                break;
        }
        return $state;
    }

    /**
     * 订单详情页显示进行步骤
     * @access public
     * @author csdeshang
     * @param array $order_info 订单信息
     * @return array
     */
    public function getVrorderStep($order_info) {
        if (!is_array($order_info) || empty($order_info))
            return array();
        $step_list = array();
        // 第一步 下单完成
        $step_list['step1'] = true;
        //第二步 付款完成
        $step_list['step2'] = !empty($order_info['payment_time']);
        //第四步 使用完成或到期结束
        $step_list['step3'] = $order_info['order_state'] == ORDER_STATE_SUCCESS;
        return $step_list;
    }

    /**
     * 取得订单数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getVrorderCount($condition) {
        return db('vrorder')->where($condition)->count();
    }

    /**
     * 订单销售记录 订单状态为20、30、40时
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @param type $pagesize 分页
     * @param type $order 排序
     * @return type
     */
    public function getVrorderAndOrderGoodsSalesRecordList($condition, $field = "*", $pagesize = 0, $order = 'order_id desc') {
        $condition['order_state'] = array('in', array(ORDER_STATE_PAY,ORDER_STATE_SUCCESS));
        return $this->getVrorderList($condition,$pagesize , $field, $order);
    }

}
