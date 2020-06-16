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
class  Fuwu extends BaseMall {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/fuwu.lang.php');
    }

    public function index() {
        //获取分类
        $o2o_fuwu_class_model = model('o2o_fuwu_class');
        $tmp_list = $o2o_fuwu_class_model->getO2oFuwuClassList(array('o2o_fuwu_class_parent_id'=>0));
        
        $class_list = array();
        if (is_array($tmp_list)) {
            foreach ($tmp_list as $k => $v) {
                $v['o2o_fuwu_class_logo_url']=get_o2o_fuwu_class_logo($v['o2o_fuwu_class_logo']);
                $v['child']=$o2o_fuwu_class_model->getO2oFuwuClassList(array('o2o_fuwu_class_parent_id'=>$v['o2o_fuwu_class_id']));
//                foreach($v['child'] as $key => $val){
//                    $v['child'][$key]['o2o_fuwu_class_logo_url']=get_o2o_fuwu_class_logo($val['o2o_fuwu_class_logo']);
//                }
                $class_list[] = $v;
            }
        }
        $this->assign('o2o_fuwu_class_list', $class_list);
        
        // 当前位置导航
        $nav_link_list=array();
        $nav_link_list[] = array('title' => lang('homepage'), 'link' => url('Home/Index/index'));
        $nav_link_list[] = array('title' => lang('fuwu_index'));
        $this->assign('nav_link_list', $nav_link_list);
        //SEO 设置
        $seo = model('seo')->type('index')->show();
        $this->_assign_seo($seo);
        return $this->fetch($this->template_dir . 'index');
    }
    

}
