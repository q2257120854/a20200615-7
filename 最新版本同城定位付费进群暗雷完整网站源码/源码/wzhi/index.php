<?php
require_once('../system/incs.php');

$sql_select = "select dingdanhao from " . flag . "order where dingdanhao = '" . $_REQUEST['out_trade_no'] . "'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if (!$row) {
    //订单记录
    $_data1['ip'] = xiaoyewl_ip();
    $_data1['vid'] = $_REQUEST['id'];
    $_data1['uid'] = get_usershipin('uid', $_REQUEST['id']);
    $_data1['dingdanhao'] = $_REQUEST['out_trade_no'];
    $_data1['vprice'] = get_usershipin('price', $_REQUEST['id']);
    $_data1['date'] = date('Y-m-d H:i:s');
    $_data1['zt'] = 0;

    $str1 = arrtoinsert($_data1);
    $sql1 = 'insert into ' . flag . 'order (' . $str1[0] . ') values (' . $str1[1] . ')';
    mysql_query($sql1);
}
error_reporting(0);
$user_agent = $_SERVER['HTTP_USER_AGENT'];

date_default_timezone_set('PRC');

include("../../config/os.php");

$url = 'https://pay.xdqj.net/createOrder';//请求地址

$skey = '';//派特密钥
$userid = 派特id; //派特用户ID


$data['payId'] = $_data1['dingdanhao'];
$data['price'] = $_data1["vprice"]; //以分为单位
//$data['order_amount'] 	= 0.01; //以分为单位
$data['userID'] = $userid;//商户ID 后台可获取

$data['notifyUrl'] = "http://" . $_SERVER['HTTP_HOST'] . "/wzhi/notifyUrl.php";//异步回调地址
$data['returnUrl'] = "http://" . $_SERVER['HTTP_HOST'] . "/wzhi/backurl.php?ddh=" . $_REQUEST['out_trade_no'];//同步回调地址
$data['type'] = '1';//公众号支付:Wxgzh 扫码支付:wxsm
$data['param'] = "办公文具";
$data['sign'] = md5(md5($data['payId'] . $data['param'] . "1" . $_data1["vprice"] . $skey) . $userid);
$data['isHtml'] = 1;
ksort($data);

$header = "";
$HTTP_REFERER = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
curl_setopt($ch, CURLOPT_REFERER, $HTTP_REFERER);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
if (!empty($data)) {
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
}

if (!empty($header)) {
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
}

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$temp = curl_exec($ch);
curl_close($ch);
Header("Location: " . $temp);

exit;