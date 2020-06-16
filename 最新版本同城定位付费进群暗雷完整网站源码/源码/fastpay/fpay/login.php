<?php
@error_reporting(E_ALL^E_NOTICE);
header('Content-Type: text/html; charset=utf-8');
extract($_GET);

if(!empty($pay_openid)){
	$back_url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$back_url=str_replace("login.php","pay.php",$back_url);
	$time_out=time()+3600*24*3;//一天后过期
	setcookie("get_openid", $pay_openid, $time_out,"/");//注册url
	sleep(1);
	header("location: {$back_url}");
	exit();
}
