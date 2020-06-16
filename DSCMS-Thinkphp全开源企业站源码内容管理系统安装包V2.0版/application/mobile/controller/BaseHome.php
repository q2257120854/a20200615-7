<?php

namespace app\mobile\controller;
use think\Controller;
use think\Lang;
use think\Request;

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
        $this->template_name = empty(config('template_name')) ? 'default' : config('template_name');
        $this->style_name = empty(config('style_name')) ? 'default' : config('style_name');
        $this->assign('template_theme', $this->template_name);
        $this->assign('style_theme', $this->style_name);
        $this->assign('nav_header', $this->_get_nav_list());
        $this->assign('link_list', $this->_get_link_list());
    }


    /**
     * 获取首页导航
     * @return array
     */
    public function _get_nav_list()
    {
        $key = 'mobile_nav';
        $mobilenav_list = rcache($key);
        if (empty($mobilenav_list)) {
            $condition['nav_display'] = 2;//1为PC端  2为手机端
            $condition['nav_location'] = 'header';
            $condition['nav_is_show'] = 1;
            //获取头部导航栏
            $mobilenav_list = model('nav')->getNavList($condition);
            wcache($key, $mobilenav_list, '', 36000);
        }
        return $mobilenav_list;
    }

    /**
     * 获取尾部友情链接
     * @return array
     */
    public function _get_link_list()
    {
        $key = 'mobile_link';
        $mobilelink_list = rcache($key);
        if (empty($mobilelink_list)) {
            $condition['link_show_ok'] = 1;
            //获取尾部友链
            $mobilelink_list = model('link')->getLinkList($condition);
            wcache($key, $mobilelink_list, '', 36000);
        }
        return $mobilelink_list;
    }

}

?>
