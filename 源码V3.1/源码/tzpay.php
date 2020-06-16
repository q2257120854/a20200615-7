<?php

error_reporting(0);
ini_set('display_errors','off');
header("Content-type: text/html; charset=utf-8");
$div='<div id="weixin-tip">  <p><img src="live_weixin.png"/></p></div>';
$css='<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"><style type="text/css">#weixin-tip{position: fixed; left:0; top:0; background: rgba(0,0,0,0.8); filter:alpha(opacity=80); width: 100%; height:100%; z-index: 100;} #weixin-tip p{text-align: center; margin-top: 10%; padding:0 5%;} #weixin-tip p img{max-width:100%;height:auto;} </style>'; 
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ){// "微信IOS”
  echo $css;
  echo $div;
  echo "请使用浏览器打开";
}else{
  if($_GET['qurl']){
    header('Location: '.$_GET['qurl']); //跳转到付款码
  }else{   
    echo "数据异常，请从新提交订单";
  }  
}
?>




