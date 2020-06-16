<?php

namespace app\admin\controller;

use think\Controller;
use think\Lang;
use think\Validate;

class Login extends Controller
{

    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/login.lang.php');
    }

    /**
     * 登录
     * @return mixed
     */
    public function index()
    {
        if (session('admin_id')) {
            $this->success('已经登录', 'Admin/Index/index');
        }
        if (request()->isPost()) {

            $admin_name = input('post.admin_name');
            $admin_password = input('post.admin_password');
            $captcha = input('post.captcha');

            $data = array(
                'admin_name' => $admin_name,
                'admin_password' => $admin_password,
                'captcha' => $captcha,
            );

            //验证数据  BEGIN
            $rule = [
                ['admin_name', 'require|min:5', '帐号为必填|帐号长度至少为5位'],
                ['admin_password', 'require|min:6', '密码为必填|帐号长度至少为6位'],
                ['captcha', 'require|min:3', '验证码为必填|帐号长度至少为3位'],
            ];
            $validate = new Validate($rule);
            $validate_result = $validate->check($data);

            if (!$validate_result) {
                ds_json_encode(10001,$validate->getError());
            }
            //验证数据  END
            if (!captcha_check(input('post.captcha'))) {
                //验证失败
                ds_json_encode(10001,'验证码错误');
            }

            $condition['admin_name'] = $admin_name;
            $condition['admin_password'] = md5($admin_password);

            $admin_info = db('admin')->where($condition)->find();
            if (is_array($admin_info) and !empty($admin_info)) {
                //更新 admin 最新信息
                $update_info = array(
                    'admin_login_num' => ($admin_info['admin_login_num'] + 1),
                    'admin_login_time' => TIMESTAMP
                );
                db('admin')->where('admin_id', $admin_info['admin_id'])->update($update_info);

                //设置 session
                session('admin_id', $admin_info['admin_id']);
                session('admin_name', $admin_info['admin_name']);
                session('admin_group_id', $admin_info['admin_group_id']);
                session('admin_is_super', $admin_info['admin_is_super']);
                ds_json_encode(10000,'登录成功');
            } else {
                ds_json_encode(10001,'帐号密码错误');
            }
        } else {
            return $this->fetch();
        }
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        //设置 session
        session(null);
        ds_json_encode(10000,'退出成功');
        exit;
    }

}


?>
