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

   $arr['money'] = $arr['price'];

    

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

$input->SetNotify_url("http://www.test.com/member/weixinpay/example/notify.php");

$input->SetTrade_type("NATIVE");

$input->SetProduct_id($_GET['oid']);

$result = $notify->GetPayUrl($input);

$url2 = $result["code_url"];

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">

<meta name="renderer" content="webkit">

<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<title>微信支付</title>

<script type="text/javascript" src="http://www.test.com/js/jquery.js"></script>

<style type="text/css">

*{margin:0;padding:0;}

body{background:#f5f5f5;font-size:14px;color:#333;font-family:"Microsoft Yahei","微软雅黑","MicrosoftJhengHei","华文细黑","Hiragino Sans GB","sans-serif";}

ul,li{list-style:none;}

h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:normal;}

i,em{font-style:normal;}

img{border:0;}

a{text-decoration:none;color:#333;}

a:hover{text-decoration:none;color:#23b8ff;}

.container{max-width:1000px;margin:0 auto;}

.clearfix:after{content:"\200b";display:block;height:0;clear:both;}



/*通用头部*/

.hd-main{background-color:#fff;margin-bottom:20px;}

.ep-logo{float:left;width:60px;height:30px;margin-top:15px;margin-right:10px;}

.ep-logo img{display:block;width:100%;height:100%;}

.ep-hd-info{padding-bottom:20px;}

.ep-order-status{float:left;padding-left:10px;border-left:1px solid #ddd;line-height:19px;font-size:16px;font-weight:700;margin-top:20px;}



/*支付成功反馈信息*/

.ep-wp-hd{padding:22px 135px;background:#f5fef3;}

.ep-status{font-size:18px;color:#1e1e1e;padding:20px 0;zoom:1;clear:both;border:none;overflow:hidden;text-align:center;}

.ep-status span{float:left;line-height:25px;}

.ep-icon-success{background-position:0 0;}

.ep-icon-success{width:23px;height:23px;}

.ep-status-success .mod-it-text{font-weight:700;}

.ep-status span{float:left;line-height:25px;}



/*订单信息*/

.text-center{background-color:#fff;padding:40px 135px 40px 135px;}

</style>

</head>

<body>



<!-- 头部 -->

<div class="hd-main">

<div class="container ep-hd-info clearfix">

<div class="ep-logo"><a href="http://www.test.com/"><img src="http://www.test.com/images/index-logo.png"></a></div>

<div class="ep-order-status">订单支付</div>

</div>

</div>

<!-- 头部 End -->



<!-- 订单信息 -->

<div class="container">

<div class="ep-wp-hd"><h2 class="ep-status ep-status-success">使用微信扫一扫支付</h2></div>

<div class="text-center" style="text-align:center;"><img alt="微信扫码支付" src="qrcode.php?data=<?php echo urlencode($url2);?>" style="width:200px;height:200px;"/></div>

</div>

<!-- 订单信息 End -->



<script>

function weipay()

    {

	$.post("http://www.test.com/member/weixinpay/ajax.php",{'ddh':'<?php echo $_GET['oid']; ?>',a:'getorder'},function(data){

		if(data  != '')

		{

		//window.location.href='http://www.test.com/member/weixinpay/ok.php?ddh=<?php echo $_GET['oid']; ?>';

		location.replace("http://www.test.com/member/weixinpay/ok.php?ddh=<?php echo $_GET['oid']; ?>");

		}

	} )

}

setInterval(weipay,3000);

</script>

</body>

</html>