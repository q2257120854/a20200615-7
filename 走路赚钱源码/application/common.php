<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function get_client_ip($type = 0) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}
	/**
	* 将字符串转换为数组
	* @param	string	$data	字符串
	* @return	array	返回数组格式，如果，data为空，则返回空数组
	*/
	function string_arr($data) {
		if(is_array($data)){return $data;}
		$data = stripslashes($data);
		$array=json_decode($data,true);
		return $array;
	}
	/**
	* 将数组转换为字符串
	* @param	array	$data		数组
	* @param	bool	$isformdata	如果为0，则不使用new_stripslashes处理，可选参数，默认为1
	* @return	string	返回字符串，如果，data为空，则返回空
	*/
	function array_str($data, $isformdata = 1) {
		if($data == '' || empty($data)) return '';
		
		if (version_compare(PHP_VERSION,'5.3.0','<')){
			return addslashes(json_encode($data));
		}else{
			return addslashes(json_encode($data,JSON_FORCE_OBJECT));
		}
	}
    /**
     * 读取理由文件的内容
	 * 创建人 杨某
	 * 时间 2017-09-10 21:27:55
     */	
	function readRoute($url='', $address='', $name=''){
		if($url && $address && $name){
			$file = CONF_PATH . 'route2.php';
			$html = false;
			
			if (is_file($file)) {
				$html = "'".$url."'=>'".$address."',/*".$name."*/
";
/* 				$myfile = false ;
				if($myfile = fopen($file, "r")){				
					$read = fread($myfile,filesize($file));
					
					$read = $html;
					//dump($read);die;
					fclose($myfile);
				}else{
					return false;
				}	 */										
			}
			return $html;			
		}else{
			return false;
		}
		
	}
	
    /**
     * 追加写入理由文件
	 * 创建人 杨某
	 * 覆盖文件
	 * 时间 2017-09-10 21:27:55
     */	
	function writeRoute($html=''){
		
		$file = CONF_PATH . 'route2.php';
		$result = false;
		if (is_file($file)) {
			$myfile = false ;
$header = "<?php
use think\Route;
";
$header = $header.'
return [
';
$html = $header.$html;
$html = $html.'
];';
			//覆盖文件
			$write =  file_put_contents($file, $html);
			//dump(file_exists($file));die;
			if(file_exists($file)){				
				$result = true;
			}else{
				return false;
			}											
		}
		return $result;	
	}
	
	
/***********************短信验证码发送*************************************************************/
	
    /**
     * 发送模板短信
	 * 创建人 杨某
	 * 时间 2017-09-06 21:15:1110
     */
     function msmSend($mobile, $orderid, $type=1)
    {
			header("Content-Type:text/html;charset=utf-8");
			$apikey = "abd12b95438c947ef1c64138f36738ca"; //修改为您的apikey
			//$mobile = input('post.mobile');//请用自己的手机号代替
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
			
			//$tpl_id = '2419488';//你自己后台报备的模板id
			
			if($type == 1){
				$text = "【财富天下】您下单的订单编号：".$orderid."已经成功买入，请及时操作";
			}elseif($type == 2){
				$text = "【财富天下】您卖出的订单编号：".$orderid."已经收到货款，请及时确认";
			}elseif($type == 3){
				$text = "【财富天下】您下单的订单编号：".$orderid."已经成功匹配，请及时操作";
			}
		
			
			// 发送短信
			$data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
			$json_data = yun_send($ch,$data);
			$array = json_decode($json_data,true);
			
			//语言通知
			/*$tpl = "【财富天下】您下单的订单编号：".$orderid."已经成功买入，请及时操作";		
			$tpl_value = urlencode($tpl);
			$data = array('tpl_id'=>$tpl_id,'tpl_value'=>$tpl_value,'apikey'=>$apikey,'mobile'=>$mobile);
			$json_data = notify_send($ch,$data);
			$array = json_decode($json_data,true);*/
 
			 curl_close($ch);
			
			if(isset($array['msg'])){
				
				if($array['msg']=='发送成功'){
					return '发送成功';					
				}else{
					return $array['msg'];
				}
				
			}else{
				return false;
			}	
    }
	
	
	//获得账户
	function get_user($ch,$apikey){
		curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/user/get.json');
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $apikey)));
		$result = curl_exec($ch);
		$error = curl_error($ch);
		checkErr($result,$error);
		return $result;
	}
	function yun_send($ch,$data){
		curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		$result = curl_exec($ch);
		$error = curl_error($ch);
		checkErr($result,$error);
		return $result;
	}
	function tpl_send($ch,$data){
		curl_setopt ($ch, CURLOPT_URL,
			'https://sms.yunpian.com/v2/sms/tpl_single_send.json');
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		$result = curl_exec($ch);
		$error = curl_error($ch);
		checkErr($result,$error);
		return $result;
	}
	function voice_send($ch,$data){
		curl_setopt ($ch, CURLOPT_URL, 'http://voice.yunpian.com/v2/voice/send.json');
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		$result = curl_exec($ch);
		$error = curl_error($ch);
		checkErr($result,$error);
		return $result;
	}
	function notify_send($ch,$data){
		curl_setopt ($ch, CURLOPT_URL, 'https://voice.yunpian.com/v2/voice/tpl_notify.json');
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		$result = curl_exec($ch);
		$error = curl_error($ch);
		checkErr($result,$error);
		return $result;
	}

	function checkErr($result,$error) {
		if($result === false)
		{
			echo 'Curl error: ' . $error;
		}
		else
		{
			//echo '操作完成没有任何错误';
		}
	}
/*-------------------------------数字加密解密--------------------------------*/
  
  function IDcodeMd5($length = 9,$key = 2543.5268431251){
	
	$strbase = "Flpvf70Csa0kVjq7geW2UP9XQ6xSyJ1izmNH6B1u3b8cAEK3wTd54nRtZOMDhoG2YLrI";
	$data['key'] = $key;
	$data['length'] = $length;
	$data['codelen'] = substr($strbase,0,$data['length']);
	$data['codenums'] = substr($strbase,$data['length'],10);
	$data['codeext'] = substr($strbase,$data['length'] + 10);
	return $data;
  }
	//字符串加密
  function number_encode($nums, $length=9){
    $rtn = "";
    $numslen = strlen($nums);
    //密文第一位标记数字的长度
	$data = IDcodeMd5($length);
	
    $begin = substr($data['codelen'],$numslen - 1,1);
    //密文的扩展位
    $extlen = $data['length'] - $numslen - 1;
    $temp = str_replace('.', '', $nums / $data['key']);
    $temp = substr($temp,-$extlen);
    $arrextTemp = str_split($data['codeext']);
    $arrext = str_split($temp);
    foreach ($arrext as $v) {
      $rtn .= $arrextTemp[$v];
    }
    $arrnumsTemp = str_split($data['codenums']);
    $arrnums = str_split($nums);
    foreach ($arrnums as $v) {
      $rtn .= $arrnumsTemp[$v];
    }
    return $begin.$rtn;
  }
  //字符串解密
  function number_decode($code, $length=9){
	$data = IDcodeMd5($length);
	  
    $begin = substr($code,0,1);
    $rtn = '';
    $len = strpos($data['codelen'],$begin);
    if($len!== false){
      $len++;
      $arrnums = str_split(substr($code,-$len));
      foreach ($arrnums as $v) {
        $rtn .= strpos($data['codenums'],$v);
      }
    }
 
    return $rtn;
  }
  
 /*------------------------------------------------------------------*/ 
	//字符穿删除空格
	function trimall($str)
	{
		$oldchar=array(" ","　","\t","\n","\r");
		$newchar=array("","","","","");
		return str_replace($oldchar,$newchar,$str);
	}
	
	/**
	 * 生成支付单编号(两位随机 + 从2000-01-01 00:00:00 到现在的秒数+微秒+会员ID%1000)，该值会传给第三方支付接口
	 * 长度 =2位 + 10位 + 3位 + 3位  = 18位
	 * 1000个会员同一微秒提订单，重复机率为1/100
	 * @return string
	 */
	 function makePaySn($member_id) {
		return mt_rand(10,99)
		      . sprintf('%010d',time() - 946656000)
		      . sprintf('%03d', (float) microtime() * 1000)
		      . sprintf('%03d', (int) $member_id % 1000);
	}
	/**
	 * 订单编号生成规则，n(n>=1)个订单表对应一个支付表，
	 * 生成订单编号(年取1位 + $pay_id取13位 + 第N个子订单取2位)
	 * 1000个会员同一微秒提订单，重复机率为1/100
	 * @param $pay_id 支付表自增ID
	 * @return string
	 */
	function makeOrderSn($pay_id, $no='') {
	    //记录生成子订单的个数，如果生成多个子订单，该值会累加
	    static $num;
	    if (empty($num)) {
	        $num = 1;
	    } else {
	        $num ++;
	    }
		return $no. (date('y',time()) % 9+1) . sprintf('%05d', $pay_id) . sprintf('%02d', $num);
	}
	
    /**
     * 查询所有的上级
	 * 修改人 杨某
	 * $liveness 是否活跃，0不活跃（为刚刚注册会员），1活跃（为正在投资的会员）
	 *  $money 交易金额  $pid上级ID $number期数 $username下级会员账号
	 * 时间 2017-09-14 21:39:01
     */	
	function parentAll($uid=0, $pid=0, $liveness=0, $money=0, $number='', $username='', $user='', $order='') 
	{
		
		if($uid){
			if(!$user){
				$user = new \Org\service\UsersService();
			}
			//更新会员活跃标记
			//!$sign && $user->userUpdate("id=".$uid , array('team_sign'=>1), $types=1);			
		}
		if($pid && $uid){
			
			$zj = array() ;
			$num = 0;
			
			//上级信息
			$member = $user->userInfo('id="'.$pid.'"');
			//上级ID
			$pid = $pid;
			$k = 0;
			$zhitui = count($zj);
			$num = $num ;
			
			while($pid>0 && $member) {
				//更新上级数据
				//是否活跃 新增活跃数量
				if($liveness && $money){
			
					
				}else{
				   //会员注册 新增团队数量
				   $user->userSetInc('id="'.$pid.'"', $field='team_num', 1);
				   //更新下级IDteam_str
				   $data = array();
				   if($member['team_str']){
					   $data['team_str'] = $member['team_str'].'|'.$uid;
				   }else{
					   $data['team_str'] = $uid; 
				   }
				   
				    $user-> userGetUpdate('id="'.$pid.'"', $data);   
				}
				//上级的上级，不断循环
				$parent = $user->userInfo('id="'.$member['refereeid'].'"');
				if($parent){
					$pid = $parent['id'];
					$k = $k + 1;
					$member = $parent;
					$zhitui = $zhitui -1 ;
					$num = $num -1 ;
				}else{
					$pid = 0;
					$member = array();
					$zhitui = 0;
					$num = 0;
					break;
				}
			}
			//dump($arr);die;		
		}
	}		