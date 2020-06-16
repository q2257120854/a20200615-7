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
class  Memberevaluate extends Model
{
    public function evaluateListDity($goods_eval_list)
    {
        foreach ($goods_eval_list as $key => $value) {
            $goods_eval_list[$key]['member_avatar'] = get_member_avatar_for_id($value['geval_frommemberid']);
        }
        return $goods_eval_list;
    }

    
    public function validationVr($order_id, $member_id) {
        $condition['order_id'] = $order_id;
        $condition['buyer_id'] = $member_id;
        //获取订单信息
        $order_info = model('vrorder')->getVrorderInfo($condition);
        if (empty($order_info)) {
            $info = array(
                'state' => '0', 'msg' => '没有权限'
            );
        }
        //订单为'已收货'状态，并且未评论
        $order_info['evaluate_able'] = model('vrorder')->getVrorderOperateState('evaluation', $order_info);
        if (!$order_info['evaluate_able']) {
            $info = array(
                'state' => '0', 'msg' => '订单已评价'
            );
        }
        //查询店铺信息
        $store_info = model('store')->getStoreInfoByID($order_info['store_id']);
        if (empty($store_info)) {
            $info = array(
                'state' => '0', 'msg' => '评价店铺不存在'
            );
        }
        //单个商品
        $order_info['goods_image_url'] = goods_cthumb($order_info['goods_image']);
        $info['data'] = array('order_info' => $order_info, 'store_info' => $store_info);
        return $info;
    }

    public function saveVr($post, $order_info, $store_info, $order_goods, $member_id, $member_name) {
        $evaluate_goods_array = array();
        $goodsid_array = array();
        $vrorder_model = model('vrorder');
        $evaluategoods_model = model('evaluategoods');
        $goods_array = input('post.goods/a'); #获取数组
        foreach ($order_goods as $value) {
            //如果未评分，默认为5分
            $evaluate_score = intval($goods_array[$value['goods_id']]['score']);
            if ($evaluate_score <= 0 || $evaluate_score > 5) {
                $evaluate_score = 5;
            }
            //默认评语
            $evaluate_comment = $goods_array[$value['goods_id']]['comment'];
            if (empty($evaluate_comment)) {
                $evaluate_comment = '不错哦';
            }

            $evaluate_goods_info = array();
            $evaluate_goods_info['geval_orderid'] = $order_info['order_id'];
            $evaluate_goods_info['geval_orderno'] = $order_info['order_sn'];
            $evaluate_goods_info['geval_ordergoodsid'] = $order_info['order_id'];
            $evaluate_goods_info['geval_goodsid'] = $value['goods_id'];
            $evaluate_goods_info['geval_goodsname'] = $value['goods_name'];
            $evaluate_goods_info['geval_goodsprice'] = $value['goods_price'];
            $evaluate_goods_info['geval_goodsimage'] = $value['goods_image'];
            $evaluate_goods_info['geval_scores'] = $evaluate_score;
            $evaluate_goods_info['geval_content'] = $evaluate_comment;
            $evaluate_goods_info['geval_isanonymous'] = input('post.anony') ? 1 : 0;
            $evaluate_goods_info['geval_addtime'] = TIMESTAMP;
            $evaluate_goods_info['geval_storeid'] = $store_info['store_id'];
            $evaluate_goods_info['geval_storename'] = $store_info['store_name'];
            $evaluate_goods_info['geval_frommemberid'] = $member_id;
            $evaluate_goods_info['geval_frommembername'] = $member_name;

            $evaluate_goods_array[] = $evaluate_goods_info;

            $goodsid_array[] = $value['goods_id'];
        }
        $evaluategoods_model->addEvaluategoodsArray($evaluate_goods_array, $goodsid_array);
        
        //更新订单信息并记录订单日志
        $state = $vrorder_model->editVrorder(array('evaluation_state' => 1, 'evaluation_time' => TIMESTAMP), array('order_id' => $order_info['order_id']));
        //添加会员积分
        if (config('points_isuse') == 1) {
            $points_model = model('points');
            $points_model->savePointslog('comments', array('pl_memberid' => $member_id, 'pl_membername' => $member_name));
        }
        //添加会员经验值
        model('exppoints')->saveExppointslog('comments', array('explog_memberid' => $member_id, 'explog_membername' => $member_name));
        return $state;
    }
}