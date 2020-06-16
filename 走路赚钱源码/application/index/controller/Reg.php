<?php
namespace app\index\controller;
use think\Controller;
use think\Url;
use think\Request;
use think\Session;
use think\Cache;

class Reg  extends controller
{
	//会员注册
    public function reg()
    {
		Cache::clear();
		$uid = input('get.present');
		// dump(Session::get('reg_mobile'));
		// dump(Session::get('reg_code'));	
		$this->assign('uid',$uid);
        return $this->fetch();
    }
	
	//会员注册操作
    public function reg_do_cmm()
    {
		if (request()->isAjax()){
			
			if(!input('post.mobile')){
				return json(['s'=>'请输入手机号码！']);	
			}
			if(!input('post.password')){
				return json(['s'=>'请输入6位以上登陆密码！']);	
			}			
			if(!input('post.sms_code')){
				return json(['s'=>'请输入短信验证码！']);	
			}
			
			if(strlen(input('post.mobile'))!= 11){
				return json(['s'=>'手机格式错误']);
			}
			
			if(strlen(input('post.password'))< 6){
				return json(['s'=>'请输入6位以上登陆密码！']);
			}
		
			if(!preg_match("/^1[345678]{1}\d{9}$/",input('post.mobile'))){
				return json(['s'=>'手机格式错误']);
			}
			
			if(!input('post.pemail_repeat')){
				return json(['s'=>'请输入邀请码！']);
			}
			
			$reg_mobile = Session::get('reg_mobile');
			$reg_code = Session::get('reg_code');
			//dump($reg_code);			
			if(!$reg_code || $reg_code!=intval(input('post.sms_code'))){
				return json(['s'=>'短信验证码错误']);
			}
			
			if(!$reg_mobile || $reg_mobile!=input('post.mobile')){
				return json(['s'=>'手机号码错误']);
			}
			
			
			$user = new \Org\service\UsersService();
			
			$data = array();
			$pid = 0 ;
			$uid = 0;
			//判断推荐人是否存在
			
			if(input('post.pemail_repeat')){
				$uid = number_decode(input('post.pemail_repeat'));
				if(!is_numeric($uid)){
					return json(['s'=>'推荐码错误']);
				}
				
				if(!preg_match("/^\d*$/",$uid)){
					return json(['s'=>'推荐码错误']);
				}
				//查找推荐人
				$filed = 'id,account';
				$where = array();
				$where['id'] = $uid;
				$result = $user->userInfo($where,$filed);
				$result = 1;//////
				if(!$result){
					return json(['s'=>'推荐人不存在']);
				}
				$data['refereeid'] = $uid;
			}
			
			$pid = $uid;
			
			$where = array();
			$info = array();
			$where['myphone'] = input('post.mobile');
			if(!$where){
				return json(['s'=>'参数错误']);
			}
			//验证手机号码是否被注册
			$info = $user->userInfo($where);
			if($info){
				return json(['s'=>'手机号码已被注册']);
			}						

			
			$data['rank'] = 1;
			$data['eth_purse'] =uniqid('0x').uniqid('av');
			
			//添加会员
			$add = $user->homeUserAdd($data);
			
			if($add){
				if($pid){
					parentAll($add, $pid) ;
				}				
				//员设置数据
				$reg_give = 0;//注册送鱼苗 送微型矿机
				$usable_coin = 0;//POW额度
				$usable_m = 0;//购机币
				//return json(['s'=>$add]);		
				$setInfo = array();
				$result = array();
				$where = array();										
				$where['id'] = ['>',0];	
				$set = new \Org\service\UserSetService();
						
				$setInfo = $set->userSetInfo($where);
				$result = unserialize($setInfo['value']);
				foreach($result as $key=>$v){
					if($key=='SET_REG_GIVE'){
						$reg_give = $v;
					}
					if($key=='SET_usable_coin'){
						$usable_coin = $v;
					}
					if($key=='SET_usable_money'){
						$usable_m = $v;
					}
				}
				$where = array();
				$where['myphone'] = input('post.mobile');
				$uinfo = $user->userInfo($where);
				
				$log = new \Org\service\LucrelogService();
				
				if($usable_coin){
					//赠送POW额度
					$save = $user->userSetInc($where, 'forepart_money', $usable_coin);
					//3赠送
					$data = array();
					$data['uid'] = $add;
					$data['explain'] = '注册送POW额度';
					$data['money'] = $usable_coin;
					$data['type'] = 3;
					$data['days'] = 0;
					$data['addtime'] = time();
					
					$log->lucrelogAdd($data);
				}
				if($usable_m){
					//赠送购机币 直接放入乐豆种子release_wallet
					$save = $user->userSetInc($where, 'release_wallet', $usable_m);
					//3赠送
					$data = array();
					$data['uid'] = $add;
					$data['explain'] = '注册赠送购机币';
					$data['money'] = $usable_m;
					$data['type'] = 3;
					$data['days'] = 0;
					$data['addtime'] = time();
					
					$log->lucrelogAdd($data);
				}
				
				if($reg_give){
					//送微型矿机
					$ore = new \Org\service\OreService();
					$where = array();
					$where['grade'] = 1;
					$oreInfo = $ore->oreInfo($where);
			
					$orderM = new \Org\service\KorderService();
					$data=array();
					
					$data['uid'] = $add;
					$data['price'] = $oreInfo['price'];
					$data['kid'] = $oreInfo['id'];
					$data['output'] = $oreInfo['output'];
					$data['profit'] = $oreInfo['profit'];
					$data['day_gain'] = $oreInfo['day_gain'];
					$data['ore_coin'] = $oreInfo['ore_coin'];
					$data['cyc'] = $oreInfo['cyc'];
					$data['addtime'] = time();
					//结束时间
					$endtime = time() + $oreInfo['cyc'] * 24 *60 * 60 ;
					$data['endtime'] = $endtime;
					$data['status'] = 1;
					
					$add = $orderM->korderAdd($data);
					if($add){
						//生成订单号
						$orderid = makeOrderSn($add, $no='MD');
						$update = $orderM->korderUpdate(array('id'=>$add), array('orderid'=>$orderid));
					}
				}
				
				Session::set('reg_mobile','');
				Session::set('reg_code','');
				return json(['s'=>'ok']);
			}else{
				return json(['s'=>'注册失败']);
			}
			
		}else{
			return json(['s'=>'参数错误']);
		}       
    }

	//发送模板短信
    public function regmm_msm_send()
    {
		if (request()->isAjax()){
			header("Content-Type:text/html;charset=utf-8");
			$apikey = "abd12b95438c947ef1c64138f36738ca"; //修改为您的apikey
			$mobile = input('post.mobile');//请用自己的手机号代替
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
			
			if(!Session::get('reg_code')){
				Session::set('reg_mobile',$mobile);
				Session::set('reg_code', $rand);
			}
			
			$code = Session::get('reg_code');
				
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
	
	
}
