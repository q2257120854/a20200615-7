<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"D:\wwwroot\yoopay.top\public/../application/index\view\login\login.html";i:1561978922;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <script src="/sb/js/mui.min.js"></script>
    <link href="/sb/css/mui.min.css" rel="stylesheet"/>
    <script type="text/javascript" charset="utf-8">
      	mui.init();
    </script>
	<style>
	.mui-input-group:before{
	background-color:#fff;
	}
	</style>
</head>
<body style="background: #fff;">
	<img src="/sb/img/public_login_bg.png" style="width: 100%;" />
	<br><br>
	<img src="/sb/img/sb.png" style="width: 35%; margin-left: 30%;" />
	<br><br>
	<!--<img src="/sb/img/login_text_image.png" style="width: 35%; margin-left: 30%;" />
	<br><br>-->
	<form class="mui-input-group" style="width: 80%; margin-left: 10%;">
					<div class="mui-input-row" style="height: 60px;">
						<label><img src="/sb/img/login_phone.png" style="position: absolute;left: 10%; margin-top:10px;"  /></label>
						<input type="number" name="username" style="font-size: 0.9em;left: 25%; position: absolute; margin-top:15px;" placeholder="请输入手机号码">
					</div>
					<div class="mui-input-row" style="height: 60px;">
						<label><img src="/sb/img/login_lock.png" style="position: absolute;left: 10%; margin-top:10px;"  /></label>
						<input type="password" name="password" style="font-size: 0.9em;left: 25%; position: absolute; margin-top:15px;" placeholder="请输入密码">
					</div>
					<a href="jiechu.html" ><p style="position: absolute;font-size: 0.7em; left: 10%;">解除设备绑定</p></a>
					<a href="findpw.html" ><p style="position: absolute; right: 10%; font-size: 0.7em;">忘记密码</p></a>
					<br><br><br>
					<div class="mui-button-row">
						<button type="button" class="mui-btn mui-btn-primary" style="margin-left: -0%; width: 40%; font-size: 1em; border-radius:30px ;" id="submit">登录</button>
						<button type="button" class="mui-btn mui-btn-primary" style="margin-left: 10%; width: 40%; font-size: 1em; border-radius:30px ;" onclick="javascrtpt:window.location.href='reg.html'">注册</button>

					</div>
				</form>
				<script>
					(function($) {
						//监听点击事件
						document.getElementById("submit").addEventListener('tap',function(){
							var username = $("input[name=username]")[0].value;
							var password = $("input[name=password]")[0].value;
							if(!username){
								alert('请输入用户名！');return false;
							}
							if(!password){
								alert('请输入登录密码！');return false;
							}
		
							console.log(username);	
							//console.log(password);
							//return false;				
							$.ajax('/userland.html',{
								data:{username:username,password:password},
								dataType:'json',//服务器返回json格式数据
								type:'post',//HTTP请求类型
								timeout:50000,//超时时间设置为50秒；
								/*headers:{'Content-Type':'application/json'},*/	              
								success:function(data){
									//服务器返回响应，根据响应结果，分析是否登录成功；
									
									if(data.s=='ok'){
										alert('登录成功');
										window.location.href = "/index.html";
									}else{
										alert(data.s);
									}
									//console.log(data);
									event.stopPropagation();
								}
							});
							event.stopPropagation();
						
						});
					})(mui);
				</script>
</body>
</html>