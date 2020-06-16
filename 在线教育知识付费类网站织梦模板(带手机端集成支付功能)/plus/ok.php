<?php

 

if(substr($out_trade_no,0,3) == 'KE-'){

    $arr = $dsql->GetOne("select * from #@__shops_orders where `oid` = '".$out_trade_no."'");

    $arr['buyid'] = $arr['oid'];

    $arr['money'] = $arr['price'];

}else{

    $arr = $dsql->GetOne("select * from #@__member_operation where `buyid` = '".$out_trade_no."'");

}





?>

<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">

<meta name="renderer" content="webkit">

<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<title>支付成功</title>

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

.ep-status{font-size:18px;color:#1e1e1e;padding:20px 0;zoom:1;clear:both;border:none;overflow:hidden;}

.ep-status span{float:left;line-height:25px;}

.ep-status span.ep-icon{margin-right:8px;}

.ep-icon-success{background-position:0 0;}

.ep-icon-success{width:23px;height:23px;}

.ep-icon{background-image:url(http://www.test.com/images/ep_new_sprites.png);background-repeat:no-repeat;display:block;}

.ep-status-success .mod-it-text{font-weight:700;}

.ep-status span{float:left;line-height:25px;}



/*订单信息*/

.text-center{background-color:#fff;padding:40px 135px 16px 135px;}

.text-center h2{line-height:26px;color:#23b8ff;font-size:18px;}

.text-center p{line-height:26px;color:#333;font-size:16px;padding-bottom:20px;}

.text-center p em{color:#e81515;}



/*返回首页*/

.text-center2{background-color:#fff;padding:0 0 100px 135px;}

.text-center2 a{width:130px;line-height:50px;font-size:16px;text-align:center;border-radius:3px;}

.text-center2 a:hover{color:#fff;}

.text-center2 .index{float:left;margin-right:20px;background-color:#ff700a;color:#fff;}

.text-center2 .index2{float:left;margin-right:20px;background-color:#a0a0a0;color:#fff;}

</style>

</head>

<body>







<!-- 头部 -->

<div class="hd-main">

<div class="container ep-hd-info clearfix">

<div class="ep-logo"><img src="http://www.test.com/images/index-logo.png"></div>

<div class="ep-order-status">订单支付</div>

</div>

</div>

<!-- 头部 End -->







<!-- 订单信息 -->

<div class="container">

<div class="ep-wp-hd">

<h2 class="ep-status ep-status-success">

<span class="ep-icon ep-icon-success"></span>

<span class="mod-it-text">支付成功！</span>

</h2>

</div>

<div class="text-center">

<p>您的订单已处理完成！</p>

<p>商品订单：<?php echo $arr['buyid']; ?></p>

<p>支付金额：<em><?php echo $arr['money']; ?>元</em></p>

</div>

<div class="text-center2">

<a href="http://www.test.com/" class="index">返回首页</a>

<a href="http://www.test.com/member/" class="index2">个人中心</a>

</div>

</div>

<!-- 订单信息 End -->







</body>

</html>