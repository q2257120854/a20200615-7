<?php

/*
 * 手机验证码
 */

namespace app\home\controller;

use think\Lang;

class Connectsms extends BaseMall {
    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/login.lang.php');
    }
    
    /**
     * 短信动态码
     */
    public function get_captcha() {
        header("Content-Type: text/html;charset=utf-8");
        $sms_mobile = input('param.sms_mobile');
        if (strlen($sms_mobile) == 11) {
            $log_type = input('param.type'); //短信类型:1为注册,2为登录,3为找回密码
            
            $member_model = model('member');
            $member = $member_model->getMemberInfo(array('member_mobile' => $sms_mobile));
//            $sms_captcha = rand(100000, 999999);
            $sms_captcha = 123123;
            $log_msg = '【' . config('site_name') . '】您于' . date("Y-m-d");
            switch ($log_type) {
                case '1':
                    if (config('sms_register') != 1) {
                        echo '系统没有开启手机注册功能';
                        exit;
                    }
                    if (!empty($member)) {
                        //检查手机号是否已被注册
                        echo '当前手机号已被注册，请更换其他号码。';
                        exit;
                    }
                    $log_msg .= '申请注册会员，动态码：' . $sms_captcha . '。';
                    break;
                case '2':
                    if (config('sms_login') != 1) {
                        echo '系统没有开启手机登录功能';
                        exit;
                    }
                    if (empty($member)) {
                        //检查手机号是否已绑定会员
                        echo '当前手机号未注册，请检查号码是否正确。';
                        exit;
                    }
                    $log_msg .= '申请登录，动态码：' . $sms_captcha . '。';
                    break;
                case '3':
                    if (config('sms_password') != 1) {
                        echo '系统没有开启手机找回密码功能';
                        exit;
                    }
                    if (empty($member)) {
                        //检查手机号是否已绑定会员
                        echo '当前手机号未注册，请检查号码是否正确。';
                        exit;
                    }
                    $log_msg .= '申请重置登录密码，动态码：' . $sms_captcha . '。';
                    break;
                default:
                    echo '参数错误';
                    exit;
                    break;
            }
            
            $smslog_model = model('smslog');
            $result = $smslog_model->sendSms($sms_mobile,$log_msg,$log_type,$sms_captcha,$member['member_id'],$member['member_name']);
            if($result['state']){
                session('sms_mobile', $sms_mobile);
                session('sms_captcha', $sms_captcha);
                echo 'true';
                exit;
            }else{
                echo $result['message'];
                exit;
            }
        } else {
            echo '手机号长度不正确';
            exit;
        }
    }

    /**
     * 验证注册动态码
     */
    public function check_captcha() {
        $state = '验证失败';
        $phone = input('get.phone');
        $captcha = input('get.sms_captcha');
        if (strlen($phone) == 11 && strlen($captcha) == 6) {
            $state = 'true';
            $condition = array();
            $condition['smslog_phone'] = $phone;
            $condition['smslog_captcha'] = $captcha;
            $condition['smslog_type'] = 1;
            $smslog_model = model('smslog');
            $sms_log = $smslog_model->getOneSms($condition);
            if (empty($sms_log) || ($sms_log['smslog_smstime'] < TIMESTAMP - 1800)) {//半小时内进行验证为有效
                $state = '动态码错误或已过期，重新输入';
            }
        }
        exit($state);
    }

    /**
     * 登录
     */
    public function login() {
        if(config('captcha_status_login')==1 && !captcha_check(input('post.captcha_mobile'))){
            ds_show_dialog('图片验证码错误', '', 'error');
        }
        
        if (request()->isPost()) {
            if (config('sms_login') != 1) {
                ds_show_dialog('系统没有开启手机登录功能', '', 'error');
            }
            $phone = input('post.sms_mobile');
            $captcha = input('post.sms_captcha');
            $condition = array();
            $condition['smslog_phone'] = $phone;
            $condition['smslog_captcha'] = $captcha;
            $condition['smslog_type'] = 2;
            $smslog_model = model('smslog');
            $sms_log = $smslog_model->getOneSms($condition);
            if (empty($sms_log) || ($sms_log['smslog_smstime'] < TIMESTAMP - 1800)) {//半小时内进行验证为有效
                ds_show_dialog('动态码错误或已过期，重新输入', '', 'error');
            }
            $member_model = model('member');
            $member = $member_model->getMemberInfo(array('member_mobile' => $phone)); //检查手机号是否已被注册
            if (!empty($member)) {
                $member_model->createSession($member); //自动登录
                $reload = input('param.ref_url');
                if (empty($reload)) {
                    $reload = url('Member/index');
                }
                $this->success('登录成功',$reload);
            }
        }
    }

    /**
     * 找回密码
     */
    public function find_password() {

        if (config('sms_password') != 1) {
            $this->error('系统没有开启手机找回密码功能');
        }
        $sms_mobile = trim(input('sms_mobile'));
        $sms_captcha = trim(input('sms_captcha'));
        $member_password = trim(input('member_password'));
        //判断验证码是否正确
        if ($sms_captcha != session('sms_captcha')) {
            $this->error('验证码错误');
        }
        if ($sms_mobile != session('sms_mobile')) {
            $this->error('手机号与接收号不一致');
        }
        
        $condition = array();
        $condition['smslog_phone'] = $sms_mobile;
        $condition['smslog_captcha'] = $sms_captcha;
        $condition['smslog_type'] = 3;
        $smslog_model = model('smslog');
        $sms_log = $smslog_model->getOneSms($condition);
        if (empty($sms_log) || ($sms_log['smslog_smstime'] < TIMESTAMP - 1800)) {//半小时内进行验证为有效
            $this->error('动态码错误或已过期，重新输入');
        }

        $member_model = model('member');
        $member = $member_model->getMemberInfo(array('member_mobile' => $sms_mobile)); //检查手机号是否已被注册
        if (!empty($member)) {
            $member_model->editMember(array('member_id' => $member['member_id']), array('member_password' => md5($member_password)));
            $member_model->createSession($member); //自动登录
            $this->error('密码修改成功');
        }
    }

}
