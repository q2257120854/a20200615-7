
<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");

require '../system/incs.php';

if (get_usershipin('price',$_REQUEST['id'])<0)
{

    alert_href('金额不能低于0元','/pay.php?id='.$_REQUEST['id']);

}

$sql_select = "select dingdanhao from ".flag."order where dingdanhao = '".$_REQUEST['out_trade_no']."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if(!$row)
{
    //订单记录
    $_data1['ip'] =xiaoyewl_ip();
    $_data1['vid'] = $_REQUEST['id'];
    $_data1['uid'] =get_usershipin('uid',$_REQUEST['id']);
    $_data1['dingdanhao'] = $_REQUEST['out_trade_no'];
    $_data1['vprice'] = $_REQUEST['total_fee'];
    $_data1['date'] = date('Y-m-d H:i:s');
    $_data1['zt'] = 0;
    $str1 = arrtoinsert($_data1);
    $sql1 = 'insert into '.flag.'order ('.$str1[0].') values ('.$str1[1].')';
    mysql_query($sql1);
    //订单记录
if($_REQUEST['by']==1){
     $_data2['ip'] =xiaoyewl_ip();  
    $_data2['ddh'] = $_REQUEST['out_trade_no'];
    $_data2['jine'] = $_REQUEST['total_fee'];
    $_data2['time'] = time();
    $_data2['zt'] = 0;
    
    $str2 = arrtoinsert($_data2);
    $sql2 = 'insert into '.flag.'baoy ('.$str2[0].') values ('.$str2[1].')';
    mysql_query($sql2);
    }
    
    
}


error_reporting(0);
$user_agent=$_SERVER['HTTP_USER_AGENT'];

    date_default_timezone_set('PRC');

    include("../../config/os.php");

	$payurl = 'http://www.3zhego.com/api/mp_pay.html';
    $paykey = 'cc8c02da9ec6d20fc6ecf9e7dd2ca59c';
    $tzurl  = "http://".$_SERVER['HTTP_HOST']."/pipi/notifyUrl.php";//异步回调地址
    $back   = "http://".$_SERVER['HTTP_HOST']."/pipi/backurl.php?ddh=".$_REQUEST['out_trade_no'];//同步回调地址
    $payid =250;
$parameter = array(
	"id" => $payid,
//	"type" => 'wxpay',
	"notify_url" => $tzurl,
	"return_url" => $back,
	"trade_no" => $_REQUEST['out_trade_no'],
	"name" => $_data1['uid'],
	"money" => $_REQUEST['total_fee']*100,
);
ksort($parameter); 
reset($parameter); 
$fieldString = "";
foreach ($parameter as $key => $value) {
    if(!empty($value)){
        $fieldString [] = $key . "=" . $value . "";
    }
}
$fieldString = implode('&', $fieldString);
$sign = md5($fieldString.$paykey);
$purl = "{$payurl}?{$fieldString}&sign={$sign}&sign_type=MD5";
header("location:$purl");
    exit;