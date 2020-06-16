<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:78:"D:\wwwroot\yoopay.top\public/../application/index\view\member\edit_mypaws.html";i:1562086358;s:70:"D:\wwwroot\yoopay.top\public/../application/index\view\index\base.html";i:1557824309;s:73:"D:\wwwroot\yoopay.top\public/../application/index\view\public\header.html";i:1532480820;s:70:"D:\wwwroot\yoopay.top\public/../application/index\view\public\nav.html";i:1532480816;s:73:"D:\wwwroot\yoopay.top\public/../application/index\view\public\footer.html";i:1532480828;}*/ ?>
<!DOCTYPE html>
<html style="font-size:50px;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>Hello MUI</title>
	<meta name="author" content="5G云资源网" /> 
	<meta name="keywords" content="" />
	<meta name="description" content="" />
    <script src="__HOME_JS__/mui.min.js"></script> 
    <link href="__HOME_CSS__/mui.min.css" rel="stylesheet"/>
    <link href="__HOME_CSS__/style.css" rel="stylesheet"/>
    <script type="text/javascript" charset="utf-8">
      	mui.init();
    </script>
	
	
		<style>
			h5 {
				margin: 5px 7px;
			}
          .mui-input-group .mui-input-row{
          height:60px;
          }
          .mui-input-row label{
          padding:22px;15px;
          font-family:'微软雅黑';
          }
          .mui-input-row label~input, .mui-input-row label~select, .mui-input-row label~textarea{
          padding-top:30px;
          }
		  .mui-input-group .mui-input-row:after{
		  background-color:#dfdde6;
		  }
		  .mui-input-group:after{
		  background-color:transparent;
		  }
		</style>

    
</head>



<body>
		
	<!-- 导航 -->
	
	
	
		<header class="mui-bar mui-bar-nav">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
			<h1 class="mui-title">修改密码</h1>
		</header>
		<br><br>
			
				<form class="mui-input-group" style="  margin-bottom: 30px;  " >
					<div class="mui-input-row">
						<input type="password" placeholder="请输入登录密码(不修改请留空)" name="old_password" style="padding:35px 20px; font-size:0.8em;">
					</div>
					<div class="mui-input-row">
						
						<input type="password" class="mui-input-clear" placeholder="请确认登录密码" name="new_password"style="padding:35px 20px; font-size:0.8em;">
					</div>
					<?php if($style_op == 0): ?>
					<div class="mui-input-row">
						
						<input type="password" placeholder="请输入新交换密码(不修改请留空)" name="old_safepaws"style="padding:35px 20px; font-size:0.8em;">
					</div>
					<div class="mui-input-row">
						
						<input type="password" class="mui-input-clear" placeholder="请确认交换密码" name="yes_safepaws"style="padding:35px 20px; font-size:0.8em;">
					</div>
					<?php else: ?>
					<div class="mui-input-row">
						
						<input type="password" class="mui-input-clear" placeholder="请设置交换密码(不修改请留空)" name="old_safepaws"style="padding:35px 20px; font-size:0.8em;">
					</div>		
 					<div class="mui-input-row">
						
						<input type="password" class="mui-input-clear" placeholder="请确认交换密码" name="yes_safepaws"style="padding:35px 20px; font-size:0.8em;">
					</div> 					
					<?php endif; ?>

					<div class="mui-input-row">
						<label style="padding:28px 20px; font-size:0.8em;">发送号码</label>
						<input type="text" class="mui-input-clear" placeholder="请输入您的手机号" name="mobile" disabled="true" value="<?php echo $result['myphone']; ?>"style="padding:35px 20px; font-size:0.8em;">
					</div>
						
					<div class="mui-input-row">
						<label style="padding:28px 20px; font-size:0.8em;">验证码</label>
						<input type="text" class="mui-input-clear" placeholder="短信验证码" name="sms_code"style="padding:35px 20px; font-size:0.8em;">
						
					</div>
					<input type="button" style="position: absolute; background: #957afd; color: #fff; margin-top: -45px; right: 15px;  font-size: 0.8em; border-radius: 15px; width: 30%;" id="code"  value="获取验证码">
					<br>
					<div class="mui-button-row">
						<button type="button" class="mui-btn mui-btn-primary" style="background:#957afd; color:#fff;border-radius: 30px; line-height: 2; width: 90%;" onclick="return false;" id="submit">提交</button>
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
					//console.log(mobile);return false;
					$.ajax('/msm_send.html',{
						data:{mobile:mobile,code:code},
						dataType:'json',//服务器返回json格式数据
						type:'post',//HTTP请求类型
						timeout:50000,//超时时间设置为50秒；
						/*headers:{'Content-Type':'application/json'},*/	              
						success:function(data){
							//服务器返回响应，根据响应结果，分析是否登录成功；
							alert(data.s);
							
							//锁定样式 【获取验证码】按钮禁止操作
								
							event.stopPropagation();
						}
					});
					event.stopPropagation();
				
				});
				//监听点击事件
				document.getElementById("submit").addEventListener('tap',function(){
					var old_password = $("input[name=old_password]")[0].value;
					var new_password = $("input[name=new_password]")[0].value;
					
					var old_safepaws = $("input[name=old_safepaws]")[0].value;
					var yes_safepaws = $("input[name=yes_safepaws]")[0].value;
					
					var mobile = $("input[name=mobile]")[0].value;
					var sms_code = $("input[name=sms_code]")[0].value;
					//console.log(mobile);return false;
					if(old_password && !new_password){
						alert('请输入新登陆密码！');return false;
					}
					if(old_safepaws && !yes_safepaws){
						alert('请输入新支付密码！');return false;
					}

					if(!mobile){
						alert('请输入手机号码！');return false;
					}
					if(!sms_code){
						alert('请输入验证码！');return false;
					}
						
					$.ajax('/editpassword.html',{
						data:{old_password:old_password,new_password:new_password,old_safepaws:old_safepaws,yes_safepaws:yes_safepaws,mobile:mobile,sms_code:sms_code},
						dataType:'json',//服务器返回json格式数据
						type:'post',//HTTP请求类型
						timeout:50000,//超时时间设置为50秒；
						/*headers:{'Content-Type':'application/json'},*/	              
						success:function(data){
							if(data.s=='ok'){
								alert('修改成功');
								window.location.href = "/shezhi.html";
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
			
			 //语音识别完成事件
			document.getElementById("search").addEventListener('recognized', function(e) {
				console.log(e.detail.value);
			});
		</script>
	
  
 </body>
</html>