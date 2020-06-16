<?php

namespace app\mobile\controller;

use think\Lang;

class BaseMember extends BaseHome
{
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/zh-cn/basemember.lang.php');
        Lang::load(APP_PATH . 'home/lang/zh-cn/memberhome.lang.php');
        /* 不需要登录就能访问的方法 */
        if (!session('member_id')) {
            $this->error('您需要先登录', url('Login/login'));
        }
        $this->template_dir = $this->template_name.'/member/'.strtolower(request()->controller()).'/';
    }
}


