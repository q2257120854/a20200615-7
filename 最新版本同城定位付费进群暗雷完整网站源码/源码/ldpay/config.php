<?php
session_start();
header("Content-type:text/html;charset=utf-8");
#数据库连接
include_once '../ewmadminfywl/inc/login.inc.php';
$payali = "ali.png";  //默认支付宝二维码 请不要修改
$payten = "ten.png";  //默认财付通二维码 请不要修改
$paywx = "wx.png";    //默认微信二维码 请不要修改

?>
