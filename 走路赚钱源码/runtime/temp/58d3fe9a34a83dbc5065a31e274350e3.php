<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"D:\wwwroot\yoopay.xiangxin.me\public/../application/index\view\login\findpw.html";i:1561960795;}*/ ?>
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
</head>
<body style="background: #fff;">
	<img src="/sb/img/public_login_bg.png" style="width: 100%;" />
	<br><br><br>
	
	<form class="mui-input-group" style="width: 80%; margin-left: 10%;">
					<div class="mui-input-row" style="height: 60px;">
						<label><img src="/sb/img/login_phone.png" style="position: absolute;left: 10%; margin-top:10px;"  /></label>
						<input name="mobile" type="number" style="font-size: 0.9em;left: 25%; position: absolute; margin-top:15px;" placeholder="请输入账号">
					</div>
					<div class="mui-input-row" style="height: 60px;">
						
						<input type="number" id="sms_code" name="sms_code" style="font-size: 0.9em;left: 21%; position: absolute; margin-top:15px;" placeholder="请输入验证码">
					</div>
					<button type="button" class="mui-btn mui-btn-primary" style="position: absolute; right: -0%; top: 75px; width: 30%; font-size: 0.7em; border-radius:30px ;" id="code">获取验证码</button>
					<div class="mui-input-row" style="height: 60px;">
						<label><img src="/sb/img/login_lock.png" style="position: absolute;left: 10%; margin-top:10px;"  /></label>
						<input type="password" name="password" style="font-size: 0.9em;left: 25%; position: absolute; margin-top:15px;" placeholder="请输入新密码">
					</div>
					<div class="mui-input-row" style="height: 60px;">
						<label><img src="/sb/img/login_lock.png" style="position: absolute;left: 10%; margin-top:10px;"  /></label>
						<input type="password" name="confirm_password" style="font-size: 0.9em;left: 25%; position: absolute; margin-top:15px;" placeholder="请输入确认密码">
					</div>
					<br>
					<br>
					<div class="mui-button-row">
						<button type="button" class="mui-btn mui-btn-primary" style="width: 80%; font-size: 1em; border-radius:30px ;" id="submit">完成</button>
						
					</div>
				</form>
				<script>
			mui.init({
				swipeBack: true //启用右滑关闭功能
			});
			(function($) {
				//监听点击事件
				document.getElementById("code").addEventListener('tap',function(){
					var mobile = $("input[name=mobile]")[0].value;
					var code = "";
					if(!mobile){
						alert('请输入手机号码！');return false;
					}
					
					var reg=/^\d{11}$/;
					if(reg.test(mobile) == false){
						alert('手机号格式不正确');
						return false;
					}
					//console.log(mobile);
					//return false;

					$.ajax('/findpw_msm_send.html',{
						data:{mobile:mobile,code:code},
						dataType:'json',//服务器返回json格式数据
						type:'post',//HTTP请求类型
						async:false,
						timeout:50000,//超时时间设置为50秒；
						/*headers:{'Content-Type':'application/json'},*/	              
						success:function(data){
							//服务器返回响应，根据响应结果，分析是否登录成功；
							alert(data.s);
							//console.log(data);
							//锁定样式 【获取验证码】按钮禁止操作
								
							event.stopPropagation();
						}
					});
					event.stopPropagation();
				
				});
				//
				document.getElementById("submit").addEventListener('tap',function(){
					var mobile = $("input[name=mobile]")[0].value;
					var sms_code = $("input[name=sms_code]")[0].value;					
					var password = $("input[name=password]")[0].value;
					var confirm_password = $("input[name=confirm_password]")[0].value;
					
					
					if(!mobile){
						alert('请输入手机号码！');return false;
					}
					
					var reg=/^\d{11}$/;
					if(reg.test(mobile) == false){
						alert('手机号格式不正确');
						return false;
					}
					if(!sms_code){
						alert('请输入手机验证码');return false;
					}
					

					if(!password){
						alert('请输入新密码！');return false;
					}
					
					if(!confirm_password){
						alert('请输入确认新密码！');return false;
					}
					if(password != confirm_password){
						alert('输入的两次密码不一致');return false;
					}
					
					console.log(mobile);	
					console.log(sms_code);
					console.log(password);
					console.log(confirm_password);
					//return false;				
					$.ajax('/resetpw.html',{
						data:{mobile:mobile,sms_code:sms_code,password:password},
						dataType:'json',//服务器返回json格式数据
						type:'post',//HTTP请求类型
						async:false,
						timeout:50000,//超时时间设置为50秒；
						/*headers:{'Content-Type':'application/json'},*/	              
						success:function(data){
							//服务器返回响应，根据响应结果，分析是否登录成功；							
							if(data.s=='ok'){
								$.toast('密码设置成功');
									setTimeout(function(){
									//页面刷新  
										window.location.href = "/login.html";
									},1500);
							}else{
								$.toast(data.s);
							}
							//console.log(data);
							//锁定样式 【获取验证码】按钮禁止操作
								
							event.stopPropagation();
						}
					});
					event.stopPropagation();
				
				});
			})(mui);
			//语音识别完成事件
			document.getElementById("search").addEventListener('recognized', function(e) {
				console.log(e.detail.value);
			});
		</script>
</body>
</html>