<?php

//接口类型：互亿无线营销短信接口，支持发送会员营销短信。
//账户注册：请通过该地址开通账户http://sms.ihuyi.com/register.html
//注意事项：
//（1）调试期间，请用默认的模板进行测试，默认模板详见接口文档；
//（2）请使用 用户名(例如：cf_demo123)及 APIkey来调用接口，APIkey在会员中心可以获取；
//（3）该代码仅供接入互亿无线短信接口参考使用，客户可根据实际需要自行编写；

header("Content-type:text/html; charset=UTF-8");

function Post($curlPost,$url){
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
	return $arr;
}

$target = "http://api.yx.ihuyi.com/webservice/sms.php?method=Submit";
$mobile = '18369259596';//手机号码，多个号码请用,隔开
$post_data = "account=cf_duoweizi&password=a4894c269771aaddd1f4dbfe581a188d&mobile=".$mobile."&content=".rawurlencode("尊敬的会员，您好，夏季新品已上市，请关注。退订回TD【互亿无线】");
//用户名是登录ihuyi.com账号名（例如：cf_demo123）
//查看密码请登录用户中心->短信营销->帐户参数设置->APIKEY

$gets =  xml_to_array(Post($post_data, $target));
echo $gets['SubmitResult']['code'];if($gets['SubmitResult']['code']==2){
	echo '提交成功';
}
?>