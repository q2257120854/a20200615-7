<?php

/*
 * 广告统计
 */

namespace app\home\controller;

use think\Lang;

class Advclick extends BaseMall {
    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/zh-cn/login.lang.php');
    }
    /**
     * 广告点击率统计
     */
    public function advclick() {
        /**
         * 取广告的相关信息
         */
        $adv_model = model('adv');
        $adv_id = intval(input('param.adv_id'));
        if($adv_id<=0){
            $this->error(lang('para_error'));
        }
        
        $condition['adv_id'] = $adv_id;
        $adv_info = $adv_model->getOneAdv($condition);
        $param['ap_id'] = $adv_info['ap_id'];
        $ap_info = $adv_model->getOneAdvposition($param);
        
        if(empty($adv_info['adv_link'])){
            $adv_info['adv_link'] = HOME_SITE_URL;
        }
        $url = str_replace(array('&amp;'), array('&'), $adv_info['adv_link']);
        
        /**
         * 写入点击率表
         */
        $adv_param['adv_id'] = $adv_id;
        $adv_param['adv_clicknum'] = $adv_info['adv_clicknum'] + 1;
        $adv_model->editAdv($adv_param);
        /**
         * 广告链接跳转
         */
        $this->redirect($url);
    }
}

?>
