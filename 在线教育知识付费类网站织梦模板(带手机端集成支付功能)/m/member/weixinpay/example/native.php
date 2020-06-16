<?php
require_once(dirname(__FILE__)."/../../config.php");
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "../lib/WxPay.Api.php";

require_once "WxPay.NativePay.php";
require_once 'log.php';

//模式一
/**
 * 流程：
 * 1、组装包含支付信息的url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、确定支付之后，微信服务器会回调预先配置的回调地址，在【微信开放平台-微信支付-支付配置】中进行配置
 * 4、在接到回调通知之后，用户进行统一下单支付，并返回支付信息以完成支付（见：native_notify.php）
 * 5、支付完成之后，微信服务器会通知支付成功
 * 6、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$notify = new NativePay();
//$url1 = $notify->GetPrePayUrl("123456789");
//weixin://wxpay/bizpayurl?appid=wx2ce0c9bdcd49a117&mch_id=1293014701&nonce_str=wsneqy8bs4i1ep2qy2q5iolx79zjj4lk&product_id=123456789&time_stamp=1455278476&sign=878BBEAB115B43D0EF92052A538A66B8

//echo '<a href="'.urlencode($url1).'">点击用微信付款</a> <a class="btn-blue" id="getBrandWCPayRequest" href="weixin://wap/pay?appid%3Dwx2b029c08a6232582%26noncestr%3Dd47bf562e96b49e50b055a932904daec%26package%3DWAP%26prepayid%3Dwx201602122009318d4368ac0e0225521090%26timestamp%3D1455278971%26sign%3D4AD41D48DB2C608396C1A48D6BD7D911">立即购买</a>';
//var_dump($url1);

//模式二
/**
 * 流程：
 * 1、调用统一下单，取得code_url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、支付完成之后，微信服务器会通知支付成功
 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$input = new WxPayUnifiedOrder();

$_GET['ddh'] = $ddh = $oid;
 


if(substr($ddh,0,3) == 'KE-'){
	$arr = $dsql->GetOne("select * from #@__shops_orders where oid = '".$_GET['ddh']."'"); 
	$trr = $dsql->GetOne("select * from #@__arctype where  id = '".$arr['pid']."'"); 
	
	$arr['pname'] = $trr['typename'];
    
if(!is_array($arr)){
	die("课程订单号".$_GET['ddh']."有误，请重新操作！");
}



	$Goods_tag = '会员充值';
 
	$jiage = $arr['price'];
	
		
}else{

     $arr = $dsql->GetOne("select * from #@__member_operation where buyid = '".$_GET['oid']."'");
    if(!is_array($arr)){
        die("订单号有误，请重新选择开通！");
    }   
    
}



 


$input->SetBody($arr['pname']);
$input->SetAttach($_GET['oid']);
$out_trade_no = WxPayConfig::MCHID.date("YmdHis");
global $dsql;
 
$input->SetOut_trade_no($out_trade_no);
$input->SetTotal_fee($arr['money'] * 100);// * 100 $arr['money'] 
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("在线订单");
$input->SetNotify_url($cfg_basehost."=/web_user/weixinpay/example/notify.php");
$input->SetTrade_type("NATIVE");
$input->SetProduct_id($_GET['oid']);




$result = $notify->GetPayUrl($input);

var_dump($result);

$url2 = $result["code_url"];

?>
<html>

<head>

    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <meta name="viewport" content="width=device-width, initial-scale=1" /> 

    <title>微信支付</title>

	<script src="/include/js/jquery/jquery.js" type="text/javascript"></script>

</head>

<body>

<div style='margin:auto;width:350px;margin-top:100px;border:1px solid #DADADA;height:150px;'>

	<div style='float:left;width:150px;'><img alt="模式二扫码支付" src="qrcode.php?data=<?php echo urlencode($url2);?>" style="width:150px;height:150px;"/></div>

	<div style="flost:left;width:350px;text-align:center">

	<p style="margin-top:50px;">使用微信扫一扫支付</p>

	<p style='font-size:14px;color:#666'>支付完成关闭此页</p>

	</div>

	

</div>

<script>

$ = jQuery;

$(function(){

	setInterval(weipay,5000);

})



function weipay()

{

	var timeStamp = new Date().getTime();

	$.get("/web_user/weixinpay/ajax.php",{'ddh':'<?php echo $_GET['oid']; ?>',a:'getorder'},function(data){

		if(data  != '')
		{
			alert(data);
			 window.location.href='/web_user';

		}

	} )

}

</script>

</body>

</html>

 