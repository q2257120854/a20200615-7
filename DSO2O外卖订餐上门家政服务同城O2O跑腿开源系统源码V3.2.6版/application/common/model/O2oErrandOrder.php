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
class  O2oErrandOrder extends Model {
    public $page_info;

    
    /**
     * 取得跑腿订单列表
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @param str $fields 字段
     * @param int $pagesize 分页信息
     * @param str $order 排序
     * @param int $limit 数量限制
     * @return array
     */
    public function getO2oErrandOrderList($condition = array(), $fields = '*', $pagesize = null, $order = 'o2o_errand_order_id desc', $limit = null) {
        if($pagesize){
            $result = db('o2o_errand_order')->where($condition)->fieldRaw($fields)->order($order)->paginate($pagesize,false,['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        }else{
            return db('o2o_errand_order')->where($condition)->field($fields)->order($order)->limit($limit)->select();
        }
        
        
    }

    /**
     * 取得跑腿订单单条
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @param string $fields 字段
     * @return array
     */
    public function getO2oErrandOrderInfo($condition = array(), $fields = '*') {
        return db('o2o_errand_order')->where($condition)->field($fields)->find();
    }
    
    /*
     * 获取订单状态
     */
    public function getO2oErrandOrderStateText($state){
        $lang='';
        switch($state){
            case 0:
                $lang='已取消';
                break;
            case 10:
                $lang='待付款';
                break;
            case 20:
                $lang='待接单';
                break;
            case 26:
                $lang='待取货';
                break;
            case 30:
                $lang='配送中';
                break;
            case 40:
                $lang='已完成';
                break;
        }
        return $lang;
    }
    
    /*
     * 获取订单按钮
     * @access public
     * @author csdeshang  
     * @param array $val 订单数据
     * @param string $operator 操作人员 member用户 admin管理员 distributor配送员
     * @return arrau
     */
    public function getO2oErrandOrderBtn($val, $operator) {

        if ($operator == 'admin') {
            $data = array(
                'if_cancel' => false,
                'if_pay' => false,
                'if_deliver' => false,
            );
            if($val['o2o_errand_order_state'] == ORDER_STATE_PAY){
                $data['if_deliver'] = true;
            }
            if ($val['o2o_errand_order_state'] != ORDER_STATE_CANCEL && $val['o2o_errand_order_state'] != ORDER_STATE_SUCCESS) {
                $data['if_cancel'] = true;
            }
            if ($val['o2o_errand_order_state'] == ORDER_STATE_NEW) {
                $data['if_pay'] = true;
            }
        } else if ($operator == 'member') {
            $data = array(
                'if_cancel' => false,
                'if_receive' => false,
                'if_pay' => false,
                'if_code' => false,
                'if_complaint'=>false,
                'if_evaluate'=>false,
            );
            if ($val['o2o_errand_order_state'] == ORDER_STATE_NEW) {
                $data['if_cancel'] = true;
                $data['if_pay'] = true;
            }
            if ($val['o2o_errand_order_state'] == ORDER_STATE_PAY) {
                $data['if_cancel'] = true;
            }

            if ($val['o2o_errand_order_state'] == ORDER_STATE_SEND) {
                $data['if_receive'] = true;
            }
            if ($val['o2o_errand_order_state'] == ORDER_STATE_SEND && $val['o2o_errand_order_check_receive'] == 1) {
                $data['if_code'] = true;
            }
            if($val['o2o_errand_order_state'] == ORDER_STATE_SUCCESS && !model('o2o_complaint')->getO2oComplaintInfo(array('o2o_complaint_order_type'=>1,'order_id'=>$val['o2o_errand_order_id']))){
                $data['if_complaint'] = true;
            }
            if($val['o2o_errand_order_state'] == ORDER_STATE_SUCCESS && !$val['o2o_errand_order_if_evaluate']){
                $data['if_evaluate'] = true;
            }
        } else if ($operator == 'distributor') {
            $data = array(
                'if_pickup' => false,
                'if_deliver' => false,
                'if_receive' => false,
            );
            if ($val['o2o_errand_order_state'] == ORDER_STATE_PAY) {
                $data['if_pickup'] = true;
            }
            if ($val['o2o_errand_order_state'] == ORDER_STATE_DELIVER) {
                $data['if_deliver'] = true;
            }
            if ($val['o2o_errand_order_state'] == ORDER_STATE_SEND && $val['o2o_errand_order_check_receive'] == 1) {
                $data['if_receive'] = true;
            }
        }

        return $data;
    }

    /**
     * 添加跑腿订单
     * @access public
     * @author csdeshang  
     * @param array $data 参数数据
     * @return type
     */
    public function addO2oErrandOrder($data) {
        return db('o2o_errand_order')->insertGetId($data);
    }
    
    /**
     * 编辑跑腿订单
     * @access public
     * @author csdeshang 
     * @param array $data 更新数据
     * @param array $condition 条件
     * @return bool
     */
    public function editO2oErrandOrder($data, $condition = array()) {
        return db('o2o_errand_order')->where($condition)->update($data);
    }
    
    /**
     * 删除跑腿订单
     * @access public
     * @author csdeshang  
     * @param array $condition 检索条件
     * @return type
     */
    public function delO2oErrandOrder($condition) {
        return db('o2o_errand_order')->where($condition)->delete();
    }
    
    /*
     * 取消跑腿订单
     * @access public
     * @author csdeshang  
     * @param array $condition 检索条件
     * @param string $operator 操作人员 member用户 admin管理员 system系统
     * @return type
     */
    public function cancelO2oErrandOrder($condition, $operator) {
        $this->startTrans();
        try {

            $o2o_errand_order_info = db('o2o_errand_order')->where($condition)->lock(true)->find();
            if (!$o2o_errand_order_info) {
                exception('订单不存在');
            }
            if ($operator == 'member') {
                if ($o2o_errand_order_info['o2o_errand_order_state'] != ORDER_STATE_NEW && $o2o_errand_order_info['o2o_errand_order_state'] != ORDER_STATE_PAY) {
                    exception('该订单不可取消');
                }
            }else{
                if ($o2o_errand_order_info['o2o_errand_order_state'] == ORDER_STATE_CANCEL || $o2o_errand_order_info['o2o_errand_order_state'] == ORDER_STATE_SUCCESS) {
                    exception('该订单不可取消');
                }
            }
            
            $predeposit_model = model('predeposit');
            if ($o2o_errand_order_info['o2o_errand_order_payment_time']) {//已付款则退还费用
                if($o2o_errand_order_info['o2o_errand_order_amount']>0){
                    $data_pd = array();
                    $data_pd['member_id'] = $o2o_errand_order_info['member_id'];
                    $data_pd['member_name'] = $o2o_errand_order_info['member_name'];
                    $data_pd['amount'] = $o2o_errand_order_info['o2o_errand_order_amount'];
                    $data_pd['order_sn'] = $o2o_errand_order_info['o2o_errand_order_sn'];
                    if (!$predeposit_model->changePd('refund', $data_pd)) {
                        exception('退款失败');
                    }
                }
            }
            if (!$this->editO2oErrandOrder(array('o2o_errand_order_state' => ORDER_STATE_CANCEL), array('o2o_errand_order_id'=>$o2o_errand_order_info['o2o_errand_order_id']))) {
                exception('订单更新失败');
            }
        } catch (\Exception $e) {
            $this->rollback();
            return ds_callback(false, $e->getMessage());
        }
        $this->commit();
        return ds_callback(true, '操作成功');
    }
    
    /*
     * 评价跑腿订单
     * @access public
     * @author csdeshang  
     * @param int $member_id 用户id
     * @param int $o2o_errand_order_id 跑题订单id
     * @param string $score 评分
     * @param string $comment 评价
     * @return type
     */
    public function evaluateO2oErrandOrder($member_id,$o2o_errand_order_id, $score, $comment) {
        if ($score < 1 || $score > 5) {
            return ds_callback(false, '评分错误');
        }
        $order_model = model('o2o_errand_order');
        $conditions = array('o2o_errand_order_id' => $o2o_errand_order_id, 'member_id' => $member_id);
        $o2o_errand_order_info = $order_model->getO2oErrandOrderInfo($conditions);
        if (!$o2o_errand_order_info) {
            return ds_callback(false, '订单不存在');
        }
        if ($o2o_errand_order_info['o2o_errand_order_state'] != ORDER_STATE_SUCCESS || $o2o_errand_order_info['o2o_errand_order_if_evaluate']) {
            return ds_callback(false, '订单不可评');
        }
        $this->startTrans();
        try {
            $result = $this->editO2oErrandOrder(array('o2o_errand_order_if_evaluate' => 1, 'o2o_errand_order_evaluate_time' => TIMESTAMP, 'o2o_errand_order_evaluate_content' => $comment, 'o2o_errand_order_evaluate_score' => $score), $conditions);
            if (!$result) {
                exception('评论保存失败');
            }
            //更新服务机构评分
            $o2o_distributor_model = model('o2o_distributor');
            $o2o_distributor_info = $o2o_distributor_model->getO2oDistributorInfo(array('o2o_distributor_id' => $o2o_errand_order_info['o2o_distributor_id']), 'o2o_distributor_id,o2o_distributor_score,o2o_distributor_comment_count');
            if ($o2o_distributor_info) {
                $count=$o2o_distributor_info['o2o_distributor_comment_count']+1;
                $score=round(($score+($o2o_distributor_info['o2o_distributor_score']*$o2o_distributor_info['o2o_distributor_comment_count']))/$count,2);
                if(!$o2o_distributor_model->editO2oDistributor(array('o2o_distributor_comment_count'=>$count,'o2o_distributor_score'=>$score),array('o2o_distributor_id'=>$o2o_distributor_info['o2o_distributor_id']))){
                    exception('评论更新失败');
                }
            }
            
        } catch (\Exception $e) {
            $this->rollback();
            return ds_callback(false, $e->getMessage());
        }
        $this->commit();
        return ds_callback(true, '操作成功');
    }
    
    /*
     * 付款跑腿订单
     * @access public
     * @author csdeshang  
     * @param string $out_trade_no 订单号
     * @param string $payment_code 支付方式
     * @param string $trade_no 第三方支付单号
     * @param string $operator 操作人员 member用户 admin管理员 system系统
     * @param string $payment_time 支付时间
     * @return type
     */
    public function payO2oErrandOrder($out_trade_no, $payment_code, $trade_no, $operator,$payment_time='') {
        $this->startTrans();
        try {

            $o2o_errand_order_info = db('o2o_errand_order')->where(array('o2o_errand_order_sn' => $out_trade_no))->lock(true)->find();
            if (!$o2o_errand_order_info) {
                exception('订单不存在');
            }
            if ($o2o_errand_order_info['o2o_errand_order_state'] != ORDER_STATE_NEW) {
                exception('该订单不可支付');
            }

            if($payment_time){
                $payment_time=strtotime($payment_time);
            }else{
                $payment_time=TIMESTAMP;
            }
            if (!$this->editO2oErrandOrder(array('o2o_errand_order_state' => ORDER_STATE_PAY, 'o2o_errand_order_payment_time' => $payment_time), array('o2o_errand_order_id' => $o2o_errand_order_info['o2o_errand_order_id']))) {
                exception('订单更新失败');
            }
        } catch (\Exception $e) {
            $this->rollback();
            return ds_callback(false, $e->getMessage());
        }
        $this->commit();
        return ds_callback(true, '操作成功');
    }
    /**
     * 取得订单数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getO2oErrandOrderCount($condition) {
        return db('o2o_errand_order')->where($condition)->count();
    }
}

?>
