<?php
	error_reporting(0); 
	require_once("./qun/inc/function.php");
	require_once("./qun/inc/getINC.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<link href="/qun/css/style.css" rel="stylesheet" type="text/css" />
<link href="/qun/css/style3.css" rel="stylesheet" type="text/css" />
<title>付费入群</title>
<script src="/qun/js/jquery.js"></script>
</head>
<body> <!-- http://appxiangjiao.oss-cn-shanghai.aliyuncs.com/6A.jpg  --->
<div id="main" style="height: 433.875px; margin-top: 26.7px;">
<img id="headimg" src="/qun/img/mm.jpg" alt="" style="height: 60.0625px;">
		<?php
			if(getCity(getIp())!='未知' ){
				if(date_default_timezone_get() != "Asia/Shanghai"){
					date_default_timezone_set("Asia/Shanghai");
				}
				echo '<h2 style="left:30px;" id="title">'.getCity(getIp()).'<span ">外围少妇资源共享群</span>'.date('',strtotime()).'</h2>';
			}else{
				echo '<h2 >外围少妇资源共享群'.date('',strtotime()).'</h2>';
			}
		?>
  <img id="code_img" src="http://qr.topscan.com/api.php?text=id=%26ld_state=2" alt="" style="height: 333.75px; margin-top: 21.6938px;">
<span id="toast" style="top: 216.938px;">该群设置了付费入群<br>支付6.00元即可入群</span>
<a href="/weixin.php" id="add" style="top: 264.938px;">立即加入</a></div>

		<?php 

			if(getCity(getIp())!='未知' ){   //获取到IP地址
				if(getCountry(getIp())=='中国' ){ 
					echo "";   //中国用户跳转页面
				}else{
					echo "<a class='bon' href='".OTHERSITE."'></a>";   //其他国家跳转页面
				}
			}else{   //没获取到IP地址
				echo "<a class='bon' href='app/index.html'></a>";   //若没获取到IP地址，则显示这段内容
			}

		?>

</body>
</html>