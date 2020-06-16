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
class  SellerO2o extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/seller_o2o.lang.php');
    }


    public function index() {
        if(!request()->isPost()){
        $this->assign('o2o_open',config('o2o_open'));
        $this->assign('store_info', $this->store_info);
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('seller_o2o');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem();
        return $this->fetch($this->template_dir.'index');
        }else{
            $store_o2o_open_time= explode(',', input('post.store_o2o_open_time'));
            $data = array(
//                'store_o2o_open' => intval(input('post.store_o2o_open')),
                'store_o2o_receipt' => abs(intval(input('post.store_o2o_receipt'))),
                'store_o2o_receipt_limit'=>abs(intval(input('post.store_o2o_receipt_limit'))),
                'store_o2o_complaint_fine'=>abs(floatval(input('post.store_o2o_complaint_fine'))),
                'store_o2o_distribute_type' => (((!$this->store_info['is_platform_store'] && $this->store_info['store_o2o_support']) || $this->store_info['is_platform_store']) && config('o2o_open'))?intval(input('post.store_o2o_distribute_type')):1,
                'store_o2o_distance' => abs(intval(input('post.store_o2o_distance'))),
                'store_o2o_fee' => abs(floatval(input('post.store_o2o_fee'))),
                'store_o2o_open_start' => $store_o2o_open_time[0],
                'store_o2o_open_end' => $store_o2o_open_time[1],
                'store_o2o_auto_receipt' => intval(input('post.store_o2o_auto_receipt')),
                'store_o2o_auto_deliver' => intval(input('post.store_o2o_auto_deliver')),
                'store_o2o_min_cost' => abs(intval(input('post.store_o2o_min_cost'))),
                'store_o2o_reject_time' => abs(intval(input('post.store_o2o_reject_time'))),
            );
            $store_model = model('store');
            $store_model->editStore($data, array('store_id' => $this->store_info['store_id']));
            $this->recordSellerlog(lang('edit_seller_o2o'));
            ds_json_encode(10000,lang('ds_common_save_succ'));
            
        }
    }
    
    protected function getSellerItemList() {
        $menu_array = array(
            1 => array(
                'name' => 'seller_o2o', 'text' => lang('baseseller_store_o2o'),
                'url' => url('seller_o2o/index')
            ),
            
        );
        return $menu_array;
    }

}

?>
