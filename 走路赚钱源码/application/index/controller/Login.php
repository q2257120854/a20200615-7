<?php
namespace app\index\controller;
use think\Controller;
use think\Url;
use think\Request;
use think\Session;
use think\Cache;

class Login  extends controller
{
	//会员登陆
    public function login()
    {
		Cache::clear();		
        return $this->fetch();
    }
	
	//会员登陆操作
    public function login_do_cmm()
    {
		if (request()->isAjax()){
			//判断会员是否可以登陆
			$LoginStatus = 1;
			$start_close = 0;
			$end_close = 0;
			$UserSet = new \Org\service\UserSetService();
			$where = array();		
			$where['id'] = ['>',0];	
			$setInfo = $UserSet->userSetInfo($where);
			$webInfo = unserialize($setInfo['value']);
			foreach($webInfo as $key=>$v){
				if($key=='SET_CLOSE'){
					$LoginStatus = $v;
				}
				if($key=='SET_start_close'){
					$start_close = $v ;
				}
				if($key=='SET_start_open'){
					$end_close = $v;
				}
			}
			if(!$LoginStatus){
				$close = "系统维护中，暂时关闭会员登陆功能.......";
				return json(['s'=>$close]);
			}
			
			//当天凌晨
			$time = date('Y-m-d',time()) ;
			
			if(preg_match("/^[1-9][0-9]*$/",$start_close)){
				$start_close = $start_close.':00';
			}
			if(preg_match("/^[1-9][0-9]*$/",$end_close)){
				$end_close = $end_close.':00';
			}
			//dump($end_close);die;
			$start_close = strtotime($start_close);
			
			$end_close = strtotime($end_close) ;
			
			$nowtime = time();
			
			if($nowtime<=$end_close && $nowtime<=$start_close && $start_close>$end_close){
				$close = "网站每天".$webInfo['SET_start_close']."时至".$webInfo['SET_start_open']."时关闭访问，请稍过后再访问.......";
				return json(['s'=>$close]);
			}elseif($nowtime<=$end_close && $nowtime>=$start_close && $start_close<$end_close){
				$close = "网站每天".$webInfo['SET_start_close']."时至".$webInfo['SET_start_open']."时关闭访问，请稍过后再访问.......";
				return json(['s'=>$close]);			
			}
			
			
			if(!input('post.username')){
				return json(['s'=>'请输入用户名！']);	
			}
			
			if(!input('post.password')){
				return json(['s'=>'请输入登录密码！']);	
			}
			
			if(strlen(input('post.username'))< 4){
				return json(['s'=>'用户名长度不能小于4位数']);
			}
			
			if(strlen(input('post.password'))< 6){
				return json(['s'=>'密码长度不能小于6位数']);
			}

			$Base = new \Org\service\BaseService();
			//地理位置信息获取
			$area = $Base->area();
			//登陆登陆验证
			$user = new \Org\service\UsersService();
			$ruesult = $user->userLogin($area);
			
			if($ruesult){
				return json(['s'=>$ruesult]);
			}else{
				return json(['s'=>'登陆失败']);
			}
			
		}else{
			return json(['s'=>'参数错误']);
		}       
    }

	//找回密码
    public function findpw()
    {
		Cache::clear();		
        return $this->fetch();
    }

	//发送模板短信(找回密码)
    public function findpw_msm_send()
    {
		if (request()->isAjax()){
			header("Content-Type:text/html;charset=utf-8");
			$apikey = "abd12b95438c947ef1c64138f36738ca"; //修改为您的apikey
			$mobile = input('post.mobile');//请用自己的手机号代替
			
			$where['myphone'] = $mobile;
			$user = new \Org\service\UsersService();
			$result = $user->userCount($where);
			
			if(empty($result)){
				return json(['s'=>'该账号不存在！']);exit;
			}

			//$text="【财富天下】您的验证码是1234";
			$ch = curl_init();

			/* 设置验证方式 */
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8',
				'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
			/* 设置返回结果为流 */
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			/* 设置超时时间*/
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);

			/* 设置通信方式 */
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

			// 发送模板短信
			// 需要对value进行编码
			$rand = rand(1000,9999);
			
			if(!Session::get('findpw_code')){
				Session::set('findpw_mobile',$mobile);
				Session::set('findpw_code', $rand);
			}
			
			$code = Session::get('findpw_code');
				
			$data = array('tpl_id' => '1', 'tpl_value' => ('#code#').
				'='.urlencode($code).
				'&'.urlencode('#company#').
				'='.urlencode('财富天下'), 'apikey' => $apikey, 'mobile' => $mobile);
			
			$json_data = tpl_send($ch,$data);
			$array = json_decode($json_data,true);
			 curl_close($ch);
			
			if(isset($array['msg'])){
				
				if($array['msg']=='发送成功'){
					return json(['s'=>'发送成功']);					
				}else{
					return json(['s'=>$array['msg']]);
				}
				
			}else{
				return json(['s'=>$array['msg']]);	
			}
		}else{
			return json(['s'=>'参数错误']);
		}
		
    }

	public function reset_password(){
		if (request()->isAjax()){
			
			header("Content-Type:text/html;charset=utf-8");

			$mobile = input('post.mobile');//手机号
			$sms_code = intval(input('post.sms_code'));//手机验证码
			$password = input('post.password');//请用自己的手机号代替
			$findpw_code = Session::get('findpw_code');
			$findpw_mobile = Session::get('findpw_mobile');
			if($mobile != $findpw_mobile){
				return json(['s'=>'手机号错误']);
			}
			if($sms_code != $findpw_code){
				return json(['s'=>'手机验证码错误']);
			}
			Session::pull('findpw_code');
			Session::pull('findpw_mobile');
			$where['myphone'] = $mobile;
			$data['password'] = sha1(md5(md5($password)));
			
			$user = new \Org\service\UsersService();
			$result = $user->userGetUpdate($where, $data);
			
			if($result){
				
				return json(['s'=>'ok']);
				
			}else{				
				return json(['s'=>'密码设置失败']);				
			}
			
		}else{
			return json(['s'=>'参数错误']);
		}
	}
	
}
