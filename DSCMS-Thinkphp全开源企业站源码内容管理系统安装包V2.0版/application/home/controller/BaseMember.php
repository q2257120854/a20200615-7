<?php

namespace app\home\controller;
use think\Lang;
/**
 * 普通用户角色
 */
class BaseMember extends BaseHome
{
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/basemember.lang.php');
        /* 不需要登录就能访问的方法 */
        if (!session('member_id') && session('is_login')!=1) {
            $this->error('您需要先登录', url('Login/login'));
        }
        $this->template_dir = $this->template_name.'/member/'.strtolower(request()->controller()).'/';
    }
}


