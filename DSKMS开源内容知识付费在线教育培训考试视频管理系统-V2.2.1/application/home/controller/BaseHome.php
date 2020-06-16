<?php

namespace app\home\controller;

use think\Controller;

/*
 * 基类
 */
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
class  BaseHome extends Controller
{

    public function _initialize()
    {
        parent::_initialize();
        //自动加入配置
        $config_list = rkcache('config', true);
        config($config_list);
        if(!config('site_state')) {
            echo config('closed_reason');
            exit;
        }
        $this->checkMessage(); //短消息检查
        $this->assign('hot_search', @explode(',', config('hot_search'))); //热门搜索
        
        // 自定义导航
        $this->assign('navs', $this->_get_navs());
        //获取所有分类
        $this->assign('header_categories', $this->_get_header_categories());
    }
    
    
    //SEO 赋值
    function _assign_seo($seo)
    {
        $this->assign('html_title', $seo['html_title']);
        $this->assign('seo_keywords', $seo['seo_keywords']);
        $this->assign('seo_description', $seo['seo_description']);
    }

    /**
     * 检查短消息数量
     *
     */
    protected function checkMessage()
    {
        if (session('member_id') == '')
            return;
        //判断cookie是否存在
        $cookie_name = 'msgnewnum' . session('member_id');
        if (cookie($cookie_name) != null) {
            $countnum = intval(cookie($cookie_name));
        }
        else {
            $message_model = model('message');
            $countnum = $message_model->getNewMessageCount(session('member_id'));
            cookie($cookie_name, $countnum, 2 * 3600); //保存2小时
        }
        $this->assign('message_num', $countnum);
    }

    public function _get_navs()
    {
        $data = array(
            'header' => array(), 'middle' => array(), 'footer' => array(),
        );
        $rows = rkcache('nav', true);
        foreach ($rows as $row) {
            $data[$row['nav_location']][] = $row;
        }
        return $data;
    }

    public function _get_header_categories()
    {
        $goodsclass_model = model('goodsclass');
        $goods_class = $goodsclass_model->get_all_category();
        return $goods_class;
    }


    /**
     * 输出会员等级
     * @param bool $is_return 是否返回会员信息，返回为true，输出会员信息为false
     */
    protected function getMemberAndGradeInfo($is_return = false)
    {
        $member_info = array();
        //会员详情及会员级别处理
        if (session('member_id')) {
            $member_model = model('member');
            $member_info = $member_model->getMemberInfoByID(session('member_id'));
            if ($member_info) {
                $member_gradeinfo = $member_model->getOneMemberGrade(intval($member_info['member_exppoints']));
                $member_info = array_merge($member_info, $member_gradeinfo);
            }
        }
        if ($is_return == true) {//返回会员信息
            return $member_info;
        }
        else {//输出会员信息
            $this->assign('member_info', $member_info);
        }
    }

    /**
     * 验证会员是否登录
     *
     */
    protected function checkLogin()
    {
        if (session('is_login') !== '1') {
            if (trim(request()->action()) == 'favoritesgoods' || trim(request()->action()) == 'favoritesstore') {
                echo json_encode(array('done' => false, 'msg' => lang('no_login')));
                die;
            }
            $ref_url = request_uri();
            if (input('get.inajax')) {
                ds_show_dialog('', '', 'js', "login_dialog();", 200);
            }
            else {
                @header("location: " . HOME_SITE_URL . "/Login/logon.html?ref_url=" . urlencode($ref_url));
            }
            exit;
        }
    }

    /**
     * 添加到任务队列
     *
     * @param array $goods_array
     * @param boolean $ifdel 是否删除以原记录
     */
    protected function addcron($data = array(), $ifdel = false)
    {
        $cron_model = model('cron');
        if (isset($data[0])) { // 批量插入
            $where = array();
            foreach ($data as $k => $v) {
                if (isset($v['content'])) {
                    $data[$k]['content'] = serialize($v['content']);
                }
                // 删除原纪录条件
                if ($ifdel) {
                    $where[] = '(type = ' . $data['type'] . ' and exeid = ' . $data['exeid'] . ')';
                }
            }
            // 删除原纪录
            if ($ifdel) {
                $cron_model->delCron(implode(',', $where));
            }
            $cron_model->addCronAll($data);
        }
        else { // 单条插入
            if (isset($data['content'])) {
                $data['content'] = serialize($data['content']);
            }
            // 删除原纪录
            if ($ifdel) {
                $cron_model->delCron(array('type' => $data['type'], 'exeid' => $data['exeid']));
            }
            $cron_model->addCron($data);
        }
    }


    /**
     * 自动登录
     */
    protected function auto_login()
    {
        $data = cookie('auto_login');
        if (empty($data)) {
            return false;
        }
        $member_model = model('member');
        if (session('is_login')) {
            $member_model->auto_login();
        }
        $member_id = intval(ds_decrypt($data, MD5_KEY));
        if ($member_id <= 0) {
            return false;
        }
        $member_info = $member_model->getMemberInfoByID($member_id);
        if (!$member_info['member_state']) {
            return false;
        }
        $member_model->createSession($member_info);
    }

}

?>
