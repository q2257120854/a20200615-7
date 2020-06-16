<?php

namespace app\home\controller;

use think\Lang;
use think\Loader;

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
class FuwuGoods extends BaseMall {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/' . config('default_lang') . '/fuwu.lang.php');
    }

    public function view() {
        $o2o_fuwu_goods_id = intval(input('param.o2o_fuwu_goods_id'));
        $o2o_fuwu_goods_model = model('o2o_fuwu_goods');
        $conditions = array('o2o_fuwu_goods_state' => 1, 'o2o_fuwu_goods_id' => $o2o_fuwu_goods_id);
        $o2o_fuwu_goods_info = $o2o_fuwu_goods_model->getO2oFuwuGoodsInfo($conditions);
        if (!$o2o_fuwu_goods_info) {
            $this->error('服务不存在');
        }
        $o2o_fuwu_goods_spec_model = model('o2o_fuwu_goods_spec');
        $o2o_fuwu_goods_spec_default = $o2o_fuwu_goods_spec_model->getO2oFuwuGoodsSpecList(array('o2o_fuwu_goods_id' => $o2o_fuwu_goods_id,'o2o_fuwu_goods_spec_type'=>0));
        if (!$o2o_fuwu_goods_spec_default) {
            $this->error('服务项目不存在');
        }
        $o2o_fuwu_goods_spec_added = $o2o_fuwu_goods_spec_model->getO2oFuwuGoodsSpecList(array('o2o_fuwu_goods_id' => $o2o_fuwu_goods_id,'o2o_fuwu_goods_spec_type'=>1));
        $o2o_fuwu_goods_info['o2o_fuwu_goods_body'] = json_decode($o2o_fuwu_goods_info['o2o_fuwu_goods_body'], true);
        $this->assign('o2o_fuwu_goods_info',$o2o_fuwu_goods_info);
        $this->assign('o2o_fuwu_goods_spec_default',$o2o_fuwu_goods_spec_default);
        $this->assign('o2o_fuwu_goods_spec_added',$o2o_fuwu_goods_spec_added);
        //获取评论
        $o2o_fuwu_order_model = model('o2o_fuwu_order');
        $evaluate_list = $o2o_fuwu_order_model->getO2oFuwuOrderList(array('o2o_fuwu_goods_id' => $o2o_fuwu_goods_id, 'o2o_fuwu_order_if_evaluate' => 1), 'member_id,member_name,o2o_fuwu_order_evaluate_time,o2o_fuwu_order_evaluate_score,o2o_fuwu_order_evaluate_content');
        $this->assign('evaluate_list',$evaluate_list);
        $this->assign('show_page', is_object($o2o_fuwu_order_model->page_info)?$o2o_fuwu_order_model->page_info->render():"");
        // 当前位置导航
        $nav_link_list = array();
        $nav_link_list[] = array('title' => lang('homepage'), 'link' => url('Home/Index/index'));
        $nav_link_list[] = array('title' => lang('fuwu_index'), 'link' => url('Home/Fuwu/index'));
        $nav_link_list[] = array('title' => lang('fuwu_organization_list'), 'link' => url('Home/FuwuOrganization/index'));
        $nav_link_list[] = array('title' => lang('fuwu_organization_info'), 'link' => url('Home/FuwuOrganization/view',['organization_id'=>$o2o_fuwu_goods_info['o2o_fuwu_organization_id']]));
        $nav_link_list[] = array('title' => lang('fuwu_goods_info'));
        $this->assign('nav_link_list', $nav_link_list);
        //SEO 设置
        $seo = model('seo')->type('index')->show();
        $this->_assign_seo($seo);
        return $this->fetch($this->template_dir . 'view');
    }

}
