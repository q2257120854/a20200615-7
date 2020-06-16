<?php

/**
 * 砍价管理
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


class Promotionbargain extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/promotionbargain.lang.php');
    }

    /**
     * 砍价列表
     */
    public function index() {
        $bargain_model = model('pbargain');
        $condition = array();
        if (!empty(input('param.bargain_name'))) {
            $condition['bargain_name'] = array('like', '%' . input('param.bargain_name') . '%');
        }
        if (!empty(input('param.store_name'))) {
            $condition['store_name'] = array('like', '%' . input('param.store_name') . '%');
        }
        if (input('param.state') != '' && in_array(input('param.state'), array(0, 1, 2, 3))) {
            $condition['bargain_state'] = intval(input('param.state'));
        }
        $bargain_list = $bargain_model->getBargainList($condition, 10, 'bargain_id desc');
        foreach ($bargain_list as $key => $val) {
            $bargain_list[$key]['bargain_state_text'] = $bargain_model->getBargainStateText($val);
            $bargain_list[$key] = array_merge($bargain_list[$key], $bargain_model->getBargainBtn($val));
        }
        $this->assign('bargain_list', $bargain_list);
        $this->assign('show_page', $bargain_model->page_info->render());
        $this->assign('bargain_state_array', $bargain_model->getBargainStateArray());

        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件

        $this->setAdminCurItem('bargain_list');
        return $this->fetch();
    }

    /**
     * 商品砍价订单列表
     */
    public function bargain_order() {
        $pbargainorder_model = model('pbargainorder');
        $bargain_id = intval(input('param.bargain_id'));
        $condition = array();
        $condition['bargain_id'] = $bargain_id;
        if(input('param.bargainorder_state')!=''){
            $condition['bargainorder_state'] = intval(input('param.bargainorder_state'));
        }

        $pbargainorder_list = $pbargainorder_model->getPbargainorderList($condition, 10); #获取开团信息
        $this->assign('show_page', $pbargainorder_model->page_info->render());
        $this->assign('pbargainorder_list', $pbargainorder_list);
        $this->assign('bargainorder_state_array', $pbargainorder_model->getBargainorderStateArray());
        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
        $this->setAdminCurItem('bargain_order');
        return $this->fetch();
    }
    /**
     * 商品砍价记录列表
     */
    public function bargain_log() {
        $pbargainlog_model = model('pbargainlog');
        $bargainorder_id = intval(input('param.bargainorder_id'));
        $condition['bargainorder_id'] = $bargainorder_id;
        $pbargainlog_list = $pbargainlog_model->getPbargainlogList($condition, 10); #获取砍价记录信息
        $this->assign('show_page', $pbargainlog_model->page_info->render());
        $this->assign('pbargainlog_list', $pbargainlog_list);
        return $this->fetch();
    }
    

    /**
     * 砍价活动 取消
     */
    public function bargain_end() {
        $bargain_id = intval(input('param.bargain_id'));
        $pbargain_model = model('pbargain');

        $bargain_info = $pbargain_model->getBargainInfoByID($bargain_id);
        if (!$bargain_info) {
            ds_json_encode(10001, lang('param_error'));
        }
        if(!in_array($bargain_info['bargain_state'],array(1,2))){//只有未开始、进行中的活动可以取消
            ds_json_encode(10001, lang('bargain_cant_cancel'));
        }
        $pbargain_model->startTrans();
        try {
            /**
             * 指定砍价活动结束
             */
            if(!$pbargain_model->cancelBargain(array('bargain_id' => $bargain_id))){
                exception(lang('bargain_edit_fail'));
            }
            if($bargain_info['bargain_state']){
                //取消用户发起的活动
                $pbargainorder_model = model('pbargainorder');
                if(!$pbargainorder_model->editPbargainorder(array('bargainorder_state'=>1,'bargain_id'=>$bargain_id), array('bargainorder_state'=>0))){
                    exception(lang('user_bargain_edit_fail'));
                }
            }
            $pbargain_model->commit();
        } catch (\Exception $e) {
            $pbargain_model->rollback();
            ds_json_encode(10001, $e->getMessage());
        }
        $this->log('砍价活动取消，活动名称：' . $bargain_info['bargain_name'] . '活动编号：' . $bargain_id, 1);
        ds_json_encode(10000, lang('ds_common_op_succ'));
    }

    /**
     * 砍价套餐管理
     */
    public function bargain_quota() {
        $bargainquota_model = model('pbargainquota');

        $condition = array();
        $condition['store_name'] = array('like', '%' . input('param.store_name') . '%');
        $bargainquota_list = $bargainquota_model->getBargainquotaList($condition, 10, 'bargainquota_endtime desc');
        $this->assign('bargainquota_list', $bargainquota_list);
        $this->assign('show_page', $bargainquota_model->page_info->render());

        $this->setAdminCurItem('bargain_quota');
        return $this->fetch();
    }

    /**
     * 砍价设置
     */
    public function bargain_setting() {
        if (!(request()->isPost())) {
            $setting = rkcache('config', true);
            $this->assign('setting', $setting);
            return $this->fetch();
        } else {
            $promotion_bargain_price = intval(input('post.promotion_bargain_price'));
            if ($promotion_bargain_price < 0) {
                $this->error(lang('param_error'));
            }

            $config_model = model('config');
            $update_array = array();
            $update_array['promotion_bargain_price'] = $promotion_bargain_price;

            $result = $config_model->editConfig($update_array);
            if ($result) {
                $this->log('修改砍价套餐价格为' . $promotion_bargain_price . '元');
                dsLayerOpenSuccess(lang('setting_save_success'));
            } else {
                $this->error(lang('setting_save_fail'));
            }
        }
    }

    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'bargain_list', 'text' => lang('bargain_list'), 'url' => url('Promotionbargain/index')
            ), array(
                'name' => 'bargain_quota', 'text' => lang('bargain_quota'),
                'url' => url('Promotionbargain/bargain_quota')
            ), array(
                'name' => 'bargain_setting',
                'text' => lang('bargain_setting'),
                'url' => "javascript:dsLayerOpen('" . url('Promotionbargain/bargain_setting') . "','" . lang('bargain_setting') . "')"
            ),
        );
        if (request()->action() == 'bargain_detail') {
            $menu_array[] = array(
                'name' => 'bargain_detail', 'text' => lang('bargain_detail'),
                'url' => url('Promotionbargain/bargain_detail')
            );
        }

        return $menu_array;
    }

}
