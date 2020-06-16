<?php
/**
	网店： http://xunyu.taobao.com/
	Q  Q: 195022431 （如需帮修改内容，可另外付费联系QQ修改）
	以下内容可根据需要修改，在单引号里修改内容
*/

	$moneyValue = '100.00';  //在这里输入您想显示在支付页面的金额
	$chinaSite = 'codepay.php';  //中国访客，跳转页面，请输入跳转的页面或网址
	$otherStie = 'app/index.html';  //其他国家访客，跳转页面，请输入跳转的页面或网址


	/**
		以下内容，请勿随意修改
	*/
	define("SETMONEY", $moneyValue);
	define("CHINASITE", $chinaSite);
	define("OTHERSITE", $otherStie); 
?>