<?php
/**
 * 手机短信类
 */

namespace sendmsg;
use AlibabaCloud\Client\AlibabaCloud;
class Sms
{
    /*
     * 发送手机短信
     * @param unknown $mobile 手机号
     * @param unknown $smslog_param 短信参数
    */
    public function send($mobile, $smslog_param)
    {
        if(config('smscf_type')=='wj'){
            $content=$smslog_param['message'];
            return $this->mysend_sms($mobile, $content);
        }elseif(config('smscf_type')=='ali'){
            return $this->ali_send($mobile, $smslog_param);
        }else{
            return ds_callback(false,lang('param_error'));
        }
    }

    /*
    您于{$send_time}绑定手机号，验证码是：{$verify_code}。【{$site_name}】
    -1	没有该用户账户
    -2	接口密钥不正确 [查看密钥]不是账户登陆密码
    -21	MD5接口密钥加密不正确
    -3	短信数量不足
    -11	该用户被禁用
    -14	短信内容出现非法字符
    -4	手机号格式不正确
    -41	手机号码为空
    -42	短信内容为空
    -51	短信签名格式不正确接口签名格式为：【签名内容】
    -6	IP限制
   大于0 短信发送数量
    http://utf8.api.smschinese.cn/?Uid=本站用户名&Key=接口安全秘钥&smsMob=手机号码&smsText=验证码:8888
    */
    public function mysend_sms($mobile, $content)
    {

        $user_id = urlencode(config('smscf_wj_username')); // 这里填写用户名
        $key = urlencode(config('smscf_wj_key')); // 这里填接口安全密钥
        if (!$mobile || !$content || !$user_id || !$key)
            return false;
        if (is_array($mobile)) {
            $mobile = implode(",", $mobile);
        }
        $mobile=urlencode($mobile);
        $content=urlencode($content);
        $url = "http://utf8.api.smschinese.cn/?Uid=" . $user_id . "&Key=" . $key . "&smsMob=" . $mobile . "&smsText=" . $content;
        if (function_exists('file_get_contents')) {
            $res = file_get_contents($url);
        }
        else {
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $res = curl_exec($ch);
            curl_close($ch);
        }

        //短信发送后返回值 说明
        $message = '';
        switch ($res){
            case "-1":
                $message = '没有该用户账号';
                break;
            case "-2":
                $message = '接口密钥不正确 [查看密钥]不是账户登陆密码';
                break;
            case "-21":
                $message = 'MD5接口密钥加密不正确';
                break;
            case "-3":
                $message = '短信数量不足';
                break;
            case "-11":
                $message = '该用户被禁用';
                break;
            case "-14":
                $message = '短信内容出现非法字符';
                break;
            case "-4":
                $message = '手机号格式不正确';
                break;
            case "-41":
                $message = '手机号码为空';
                break;
            case "-42":
                $message = '短信内容为空';
                break;
            case "-51":
                $message = '短信签名格式不正确接口签名格式为：【签名内容】';
                break;
            case "-6":
                $message = 'IP限制';
                break;
        }
        if($res>0){
            return ds_callback(true);
        }else{
            return ds_callback(false,$message);
        }
    }
    
    public function ali_send($mobile, $smslog_param) {
        if(!$smslog_param['ali_template_code']){
            return ds_callback(false,'请绑定模板code');
        }
        AlibabaCloud::accessKeyClient(config('smscf_ali_id'), config('smscf_ali_secret'))
                ->regionId('cn-hangzhou')
                ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                    ->product('Dysmsapi')
                    // ->scheme('https') // https | http
                    ->version('2017-05-25')
                    ->action('SendSms')
                    ->method('POST')
                    ->host('dysmsapi.aliyuncs.com')
                    ->options([
                        'query' => [
                            'RegionId' => "cn-hangzhou",
                            'PhoneNumbers' => $mobile,
                            'SignName' => config('smscf_sign'),
                            'TemplateCode' => $smslog_param['ali_template_code'],
                            'TemplateParam' => json_encode($smslog_param['ali_template_param']),
                        ],
                    ])
                    ->request();
        } catch (\Exception $e) {
            return ds_callback(false,$e->getMessage());
        }
        $result=$result->toArray();
        
        if($result['Code']!='OK'){
            return ds_callback(false,$result['Message']);
        }else{
            return ds_callback(true);
        }
    }

}
