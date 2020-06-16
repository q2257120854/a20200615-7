<?php

require_once(dirname(__FILE__)."/../config.php");

	//购买课程

	if(substr($ddh,0,3) == 'KE-'){

		$arr = $dsql->GetOne("select * from #@__shops_orders where `oid` = '".$ddh."'");		

 		$arr['buyid'] = $arr['oid'];

		$arr['money'] = $arr['price'];	

		//$url = '/list.php?tid='.$arr['pid'];

		$url = 'http://m.test.com/';

	}else{

		$arr = $dsql->GetOne("select * from #@__member_operation where `buyid` = '".$ddh."'");

		$url = 'http://m.test.com/' ;

	}



?>

<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8" />

<title>支付成功</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<meta content="yes" name="apple-mobile-web-app-capable" />

<meta content="black" name="apple-mobile-web-app-status-bar-style" />

<meta content="telephone=no" name="format-detection" />

<script type="text/javascript" src="http://m.test.com/m-js/jquery.js"></script>

<script type="text/javascript" src="http://m.test.com/m-css/app.css.php?format=js&v=1.01"></script>

<style type="text/css">

body{background:#fff;font-size:14px;color:#333;font-family:-apple-system,BlinkMacSystemFont,Helvetica Neue,PingFang SC,Microsoft YaHei,Source Han Sans SC,Noto Sans CJK SC,WenQuanYi Micro Hei,sans-serif;}

*{margin:0;padding:0;}

ul,li{list-style:none;}

h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:normal;}

i,em{font-style:normal;}

a{text-decoration:none;color:#333;}

a:hover{text-decoration:none;color:#23b8ff;}

#preloader{margin:0 !important;padding:0 !important;}

#status{max-width:800px !important;}

#preloader .center-yxw-img{display:none !important;}

.center-text{display:none;}

.container{max-width:800px;min-width:320px;margin:0 auto;}



/*支付成功反馈信息*/

.ep-wp-hd{padding-top:50px;}

.ep-wp-hd .ep-status{font-size:20px;color:#ff700a;padding:10px 0;text-align:center;}

.ep-wp-hd .ep-icon{width:45px;height:45px;margin:0 auto;background:url(http://m.test.com/m-images/pay-wanchen.png) no-repeat;background-size:45px 45px;display:block;}



.text-center{padding:20px 0;text-align:center;}

.text-center h2{line-height:26px;color:#23b8ff;font-size:18px;}

.text-center p{color:#333;font-size:16px;padding-bottom:20px;}

.text-center p em{font-size:12px;padding-right:2px;}

.text-center p span{font-size:28px;}

.text-center a{line-height:38px;border:1px solid #ff700a;color:#ff700a;font-size:16px;display:inline-block;border-radius:5px;padding:0 40px;}

</style>

</head>

<body>



<!-- 订单支付信息 -->

<div class="container">

<div class="ep-wp-hd"><i class="ep-icon"></i><h2 class="ep-status">支付成功</h2></div>

<div class="text-center">

<p>订单号：<?php echo $arr['buyid']; ?></p>

<p><em>￥</em><span><?php echo $arr['money']; ?></span></p>

<a href="<?php echo $url; ?>" class="text-link">完成</a>

</div>

</div>

<!-- 订单支付信息 End -->



</body>

</html>