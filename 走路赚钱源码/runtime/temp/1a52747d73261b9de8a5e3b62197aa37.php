<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\wwwroot\yoopay.xiangxin.me\public/../application/index\view\reg\reg.html";i:1561978777;}*/ ?>
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
	<br><br>
	<img src="/sb/img/sb.png" style="width: 35%; margin-left: 30%;" />
	<br><br>
	<img src="/sb/img/login_text_image.png" style="width: 35%; margin-left: 30%;" />
	<br><br>
	<form class="mui-input-group" id='login-form' style="width: 80%; margin-left: 10%;">
					<div class="mui-input-row" style="height: 60px;">
						<label><img src="/sb/img/login_phone.png" style="position: absolute;left: 10%; margin-top:10px;"  /></label>
						<input name="mobile" type="number" style="font-size: 0.9em;left: 25%; position: absolute; margin-top:15px;" placeholder="请输入手机号码">
					</div>
					<div class="mui-input-row" style="height: 60px;">
						
						<input type="number" id="sms_code" name="sms_code" style="font-size: 0.9em;left: 21%; position: absolute; margin-top:15px;" placeholder="请输入验证码">
					</div>
					<button type="button" class="mui-btn mui-btn-primary" style="position: absolute; right: -0%; top: 75px; width: 30%; font-size: 0.7em; border-radius:30px ;" id="code">获取验证码</button>
					<div class="mui-input-row" style="height: 60px;">
						<label><img src="/sb/img/login_lock.png" style="position: absolute;left: 10%; margin-top:10px;"  /></label>
						<input type="password" name="password" style="font-size: 0.9em;left: 25%; position: absolute; margin-top:15px;" placeholder="请输入密码">
					</div>
					<div class="mui-input-row" style="height: 60px;">
						<label><img src="/sb/img/login_lock.png" style="position: absolute;left: 10%; margin-top:10px;"  /></label>
						<input type="password" id="confirm_password" style="font-size: 0.9em;left: 25%; position: absolute; margin-top:15px;" placeholder="请重复密码">
					</div>
					<div class="mui-input-row" style="height: 60px;">
						<label><img src="/sb/img/login_lock.png" style="position: absolute;left: 10%; margin-top:10px;"  /></label>
						<input type="text"name="pemail_repeat" value="<?php if($uid != ''): ?><?php echo $uid; endif; ?>" style="font-size: 0.9em;left: 25%; position: absolute; margin-top:15px;" placeholder="请输入推荐人ID">
					</div>
					<br>
					<a href="" ><p style="position: absolute; left: 30%; font-size: 0.8em;">注册即同意《闪步用户协议》</p></a>
					<br><br>
					<div class="mui-button-row">
						<button type="button" id="submit" class="mui-btn mui-btn-primary" style="width: 80%; font-size: 1em; border-radius:30px ;" onclick="return false;">注册</button>
						
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
					$.ajax('/msm_send.html',{
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
					var pemail_repeat = $("input[name=pemail_repeat]")[0].value;
					var password = $("input[name=password]")[0].value;
					
					if(!mobile){
						alert('请输入手机号码！');return false;
					}
					var reg=/^\d{11}$/;
					if(reg.test(mobile) == false){
						alert('手机号格式不正确');
						return false;
					}
					
					if(!password){
						alert('请输入6位以上登陆密码！');return false;
					}
					
					if(!pemail_repeat){
						alert('请输入邀请码！');return false;
					}
					
					console.log(mobile);	
					console.log(sms_code);
					console.log(pemail_repeat);
					//return false;				
					$.ajax('/register.html',{
						data:{mobile:mobile,sms_code:sms_code,pemail_repeat:pemail_repeat,password:password},
						dataType:'json',//服务器返回json格式数据
						type:'post',//HTTP请求类型
						async:false,
						timeout:50000,//超时时间设置为50秒；
						/*headers:{'Content-Type':'application/json'},*/	              
						success:function(data){
							//服务器返回响应，根据响应结果，分析是否登录成功；							
							if(data.s=='ok'){
								$.toast('注册成功');
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