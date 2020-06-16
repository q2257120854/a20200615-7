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
class  Showjoinin extends BaseMall {
    

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/showjoinin.lang.php');
    }
    /*
     * 入驻相关首页介绍
     */

    public function index() {
        $code_info = config('store_joinin_pic');
        $info['pic'] = array();
        $info['show_txt'] = '';
        if (!empty($code_info)) {
            $info = unserialize($code_info);
        }
        $this->assign('pic_list', $info['pic']); //首页图片
        $this->assign('show_txt', $info['show_txt']); //贴心提示
        $help_model = model('help');
        $condition['helptype_id'] = '1'; //入驻指南
        $help_list = $help_model->getHelpList($condition, '', 4); //显示4个
        //获取第一文章分类的前三篇文章
        $index_articles=db('article')->where('ac.ac_code','notice')->where('a.article_show',1)->alias('a')->field('a.article_id,a.article_url,a.article_title')->order('a.article_sort asc,a.article_time desc')->limit(5)->join('__ARTICLECLASS__ ac','a.ac_id=ac.ac_id')->select();
        $this->assign('index_articles', $index_articles);
        $this->assign('help_list', $help_list);
        $this->assign('show_sign', 'joinin');
        $this->assign('html_title', config('site_name') . ' - ' . lang('tenants'));
        return $this->fetch($this->template_dir . 'index');
    }

}

?>
