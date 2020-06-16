<?php
require_once(dirname(__FILE__)."/config.php");
require_once DEDEINC.'/membermodel.cls.php';

function sendsms($mobiles, $content,$type="sms"){
	$info=explode(',',$mobiles);
	$mobile=$info[2];
	$row['value']=$info[0];
	$row_pwd['value']=$info[1];
	//配置信息
	if($type=="sms"){
		$target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";	
		//替换成自己的测试账号,参数顺序和wenservice对应
		$post_data = "account=". $row['value'] ."&password=".md5($row_pwd['value'])."&md5=1&mobile=".$mobile."&content=".urlencode($content);

	}else{
		$target = "http://api.voice.ihuyi.com/webservice/voice.php?method=Submit";
		//替换成自己的测试账号,参数顺序和wenservice对应
		$post_data = "account=". $row['value'] ."&password=".$row_pwd['value']."&mobile=".$mobile."&content=".urlencode($content);

	}
	$gets = '<?xml version="1.0" encoding="utf-8"?>
	<SubmitResult xmlns="http://106.ihuyi.cn/">
	<code>2</code>
	<msg>提交成功</msg>
	<smsid>67472311</smsid>
	</SubmitResult>';


	if($GLOBALS['_CFG']['ihuyi_sms_debug']==0){
		$gets = ihuyi_Post($post_data,$target);
	}	
	
	$gets_arr = xml_to_array($gets);
	
	file_put_contents(dirname(dirname(__FILE__))."/sms_log_".$GLOBALS['_CFG']['ihuyi_sms_user_name'].".log",'发送状态：'.$gets_arr['SubmitResult']['msg']."\r\n",FILE_APPEND);
	
	if ($gets_arr['SubmitResult']['code'] == 2){
		return true;
	}else{
		return $gets_arr['SubmitResult']['msg']; 
	}
}

function ismobile($mobile){
	return (strlen($mobile) == 11 || strlen($mobile) == 12) && (preg_match("/^13\d{9}$/", $mobile) || preg_match("/^14\d{9}$/", $mobile) || preg_match("/^15\d{9}$/", $mobile) || preg_match("/^18\d{9}$/", $mobile) || preg_match("/^0\d{10}$/", $mobile) || preg_match("/^0\d{11}$/", $mobile));
}

function getverifycode() {
	$length = 6;
	PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
	$hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
	return $hash;
}

function ihuyi_Post($curlPost,$url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
		$return_str = curl_exec($curl);
		curl_close($curl);
		return $return_str;
}

function xml_to_array($xml){
	$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
	if(preg_match_all($reg, $xml, $matches)){
		$count = count($matches[0]);
		for($i = 0; $i < $count; $i++){
		$subxml= $matches[2][$i];
		$key = $matches[1][$i];
			if(preg_match( $reg, $subxml )){
				$arr[$key] = xml_to_array( $subxml );
			}else{
				$arr[$key] = $subxml;
			}
		}
	}
	return @$arr;
}
?>