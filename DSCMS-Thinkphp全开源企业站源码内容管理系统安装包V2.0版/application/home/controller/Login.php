<?php

namespace app\home\controller;
use think\Validate;
use think\Lang;
class Login extends BaseMall
{
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/login.lang.php');
    }

    /**
     * 用户登录
     * @return mixed
     */
    public function login()
    {
        $member_model = model('member');
        $inajax = input('param.inajax');
        //检查登录状态
        $member_model->checkloginMember();
        if (!request()->isPost()) {
            if ($inajax==1) {
                return $this->fetch($this->template_dir . 'login_inajax');
            } else {
                return $this->fetch($this->template_dir . 'login');
            }
        }else {
            if (config('captcha_status_login') == 1 && !captcha_check(input('post.captcha_normal'))) {
                if($inajax==1){
                    ds_show_dialog('图片验证码错误', '', 'error');
                }else{
                    $this->error('图片验证码错误',url('Login/login'));
                }
            }
            $data = array(
                'member_name' => input('post.member_name'),
                'member_password' => input('post.member_password'),
            );
            //验证数据  BEGIN
            $rule = [
                ['member_name', 'require', '账户为必填'],
                ['member_password', 'require', '密码为必填']
            ];
            $validate = new Validate($rule);
            $validate_result = $validate->check($data);
            if (!$validate_result) {
                if($inajax==1){
                    ds_show_dialog($validate->getError(), '', 'error');
                }else{
                    $this->error($validate->getError());
                }
            }
            //验证数据  END
            $map = array(
                'member_name' => $data['member_name'],
                'member_password' => md5($data['member_password']),
            );
            $member_info = $member_model->getMemberInfo($map);
            if (empty($member_info) && preg_match('/^0?(13|15|17|18|14)[0-9]{9}$/i', $data['member_name'])) {
                //根据会员名没找到时查手机号
                $map = array();
                $map['member_mobile'] = $data['member_name'];
                $map['member_password'] = md5($data['member_password']);
                $member_info = db('member')->where($map)->find();
            }
            if (empty($member_info) && (strpos($data['member_name'], '@') > 0)) {
                //按邮箱和密码查询会员
                $map = array();
                $map['member_email'] = $data['member_name'];
                $map['member_password'] = md5($data['member_password']);
                $member_info = db('member')->where($map)->find();
            }
            if ($member_info) {
                if(!$member_info['member_state']){
                    if($inajax==1){
                        ds_show_dialog(lang('login_index_account_stop'), '', 'error');
                    }else{
                        $this->error(lang('login_index_account_stop'), 'Index/index');
                    }
                }
                //执行登录,赋值操作
                $member_model->createSession($member_info);

                if ($inajax == 1) {
                    ds_show_dialog('', input('param.ref_url') == '' ? 'reload' : input('param.ref_url'), 'js');
                } else {
                    if ('' != input('param.ref_url')) {
                        $this->success('登录成功', input('param.ref_url'));
                    }else{
                        $this->success('登录成功', 'Member/index');
                    }
                }
            } else {
                if($inajax==1){
                    ds_show_dialog('登录失败', '', 'error');
                }else{
                    $this->error('登录失败','Login/login');
                }
            }
        }
    }

    /**
     * 退出登录
     */
    public function logout(){
        //设置 session
        session(null);
        $this->redirect('Index/index');
        exit;
    }

    /**
     * 忘记密码
     * @return mixed
     */
    public function forget_password()
    {
        return $this->fetch($this->template_dir . 'find_password');
    }

    /**
     * 用户注册
     * @return mixed
     */
    public function register()
    {
        $member_model = model('member');
        if (!request()->isPost()) {
            $member_model->checkloginMember();
            return $this->fetch($this->template_dir . 'register');
        }else {
            if (config('captcha_status_register') == 1 && !captcha_check(input('post.captcha_normal'))) {
                $this->error('图片验证码错误');
            }
            $member_model = model('member');
            $member_model->checkloginMember();

            $data = array(
                'member_name' => input('post.member_name'),
                'member_password' => input('post.member_password'),
            );

            //用户名随机生成
            for ($i = 1; $i < 999; $i++) {
                $member_name = random(10);
                $member_info = $member_model->getMemberInfo(array('member_name' => $member_name));
                if (empty($member_info)) {//查询为空表示当前会员名可用
                    $data['member_name']=$member_name;
                    break;
                }
            }
            //是否开启验证码
            if (config('sms_register')) {
                $sms_mobile = trim(input('sms_mobile'));
                $sms_captcha = trim(input('sms_captcha'));
                if (strlen($sms_mobile) != 11 || strlen($sms_captcha) != 6) {
                    $this->error('手机号或手机验证码长度不正确');
                }
                //判断验证码是否正确
                if ($sms_captcha != session('sms_captcha')) {
                    $this->error('验证码错误');
                }
                if ($sms_mobile != session('sms_mobile')) {
                    $this->error('手机号与接收号不一致');
                }
                //检测手机号是否被注册
                $check_member_mobile = $member_model->getMemberInfo(array('member_mobile' => $sms_mobile));
                if (!empty($check_member_mobile)) {
                    $this->error('手机号已被注册');
                }
                $sms_condition = array(
                    'smslog_phone' => $sms_mobile,
                    'smslog_captcha' => $sms_captcha,
                    'smslog_type' => '1',
                );
                $smslog_model = model('smslog');
                $sms_log = $smslog_model->getOneSms($sms_condition);
                if (empty($sms_log) || ($sms_log['smslog_smstime'] < TIMESTAMP - 1800)) {//半小时内进行验证为有效
                    $this->error('动态码错误或已过期，重新输入');
                }

                $data['member_mobile'] = $sms_mobile;
                $data['member_mobilebind'] = 1;
            }
            //验证数据  BEGIN
            $rule = [
                ['member_name', 'require|length:3,15', '账户为必填|帐号长度必须为3-15之间'],
                ['member_password', 'require|length:6,20', '密码为必填|密码长度必须为6-20之间']
            ];
            $validate = new Validate($rule);
            $validate_result = $validate->check($data);
            if (!$validate_result) {
                $this->error($validate->getError());
            }
            //验证数据  END
            $member_info = $member_model->register($data);
            if ($member_info) {
                $member_model->createSession($member_info, true);
                $ref_url = url('Member/index');
                if (strstr(input('post.ref_url'), 'logout') === false && !empty(input('post.ref_url'))) {
                    $ref_url = input('post.ref_url');
                }
                $this->redirect($ref_url);
            } else {
                $this->error('注册失败');
            }
        }
    }
}