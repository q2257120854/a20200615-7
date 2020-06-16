<?php

namespace app\home\controller;
use think\Controller;
use think\Lang;
use think\Request;
use think\Session;
/**
 * 基类
 */
class BaseHome extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        //自动加入配置
        $config_list = rkcache('config', true);
        config($config_list);
        if (!config('site_state')) {
            echo config('closed_reason');
            exit;
        }
        if (in_array(cookie('ds_home_lang'), array('zh-cn', 'en-us'))) {
            config('default_lang', cookie('ds_home_lang'));
        }
        Lang::load(APP_PATH . 'home/lang/' . config('default_lang') . '.php');
        
        $this->template_name = empty(config('template_name')) ? 'default' : config('template_name');
        $this->style_name = empty(config('style_name')) ? 'default' : config('style_name');
        $this->assign('template_theme', $this->template_name);
        $this->assign('style_theme', $this->style_name);
        $this->assign('nav_header', $this->_get_nav_list());
        $this->assign('link_list', $this->_get_link_list());
    }
    
    /**
     * SEO赋值
     * @param type $seo
     */
    function _assign_seo($seo = array()) {
        $seo_home_title_type = config('seo_home_title_type');
        if(!isset($seo['seo_title'])){
            $seo['seo_title']  = config('site_name');
        }
        switch ($seo_home_title_type) {
            case 0:
                $this->assign('seo_title', $seo['seo_title']);
                break;
            case 1:
                $this->assign('seo_title', $seo['seo_title'].'-'.config('seo_home_keywords'));
                break;
            case 2:
                $this->assign('seo_title', $seo['seo_title'].'-'.config('seo_home_title'));
                break;
            case 2:
                $this->assign('seo_title', $seo['seo_title'].'-'.config('seo_home_title').'-'.config('seo_home_keywords'));
                break;
        }
        if(isset($seo['seo_keywords'])){
            $this->assign('seo_keywords', $seo['seo_keywords']);
        }else{
            $this->assign('seo_keywords', config('seo_home_keywords'));
        }
        if(isset($seo['seo_description'])){
            $this->assign('seo_description', $seo['seo_description']);
        }else{
            $this->assign('seo_description', config('seo_home_description'));
        }
    }


    /**
     * 获取首页导航
     * @return array
     */
    public function _get_nav_list()
    {
        $condition = array();
        $key = 'home_nav';
        $homenav_list = rcache($key);
        if (empty($homenav_list)) {
            //获取头部导航栏
            $condition['nav_display'] = 1;//1为PC端  2 为手机端
            $condition['nav_location'] = 'header';
            $condition['nav_is_show'] = 1;
            $homenav_list = model('nav')->getNavList($condition);
            wcache($key, $homenav_list, '', 36000);
        }
        return $homenav_list;
    }

    /**
     * 获取尾部友情链接
     * @return array
     */
    public function _get_link_list()
    {
        $condition = array();
        $key = 'home_link';
        $homelink_list = rcache($key);
        if (empty($homelink_list)) {
            //获取尾部友链
            $condition['link_show_ok'] = 1;
            $homelink_list = model('link')->getLinkList($condition);
            wcache($key, $homelink_list, '', 36000);
        }
        return $homelink_list;
    }

}

?>
