<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"D:\wwwroot\yoopay.top\public/../application/index\view\member\my_information.html";i:1562089407;}*/ ?>
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
	.mui-input-group .mui-input-row:after{
	background-color:transparent;
	}
	.mui-table-view:after{
	background-color:#ffffff;
	}
	.mui-table-view:before{
	background-color:#ffffff;
	}
	</style>
</head>
<body style="background: #fff;">
	<header class="mui-bar mui-bar-nav" style="background: #fff;">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
					<!--<a href="#"><span style="position: absolute; font-size: 0.9em; margin-top: 10px; right: 10px;"id="submit">提交</span></a>-->
					<h1 class="mui-title">身份信息</h1>
		</header>
		<br><br><br>
		<ul class="mui-table-view">
		 <li class="mui-table-view-cell" style="line-height: 2.7em;font-size:0.9em;">头像 <img src="/sb/img/house_img_save.png" style="width: 50px; position: absolute; top: 0px; right: 30px;" ></li>
		
		</ul>
		<form class="mui-input-group">
					<div class="mui-input-row" style="height: 60px;">
						<label style="position: absolute; top: 12px;font-size:0.9em;">推荐人ID</label>
						<input type="text"  value="<?php if($pid != '0'): ?><?php echo $pid; endif; ?>" disabled="true" style="margin-top: 10px;font-size:0.9em; margin-right:-130px;"placeholder="请输入手机号码">
					</div>
					<div class="mui-input-row" style="height: 60px;">
						<label style="position: absolute; top: 12px;font-size:0.9em;">手机号码</label>
						<input type="number" name="mobile" disabled="true" value="<?php echo $result['myphone']; ?>" style="margin-top: 10px;font-size:0.9em;margin-right:-130px;"placeholder="请输入手机号码">
					</div>
					
					<div class="mui-input-row" style="height: 60px;">
						<label style="position: absolute; top: 12px;font-size:0.9em;">ID</label>
						<input type="number"value="<?php if($result['account'] != '0'): ?><?php echo $result['account']; endif; ?>" name="username" style="margin-top: 10px;font-size:0.9em;margin-right:-130px;"placeholder="请输入ID">
					</div>
					<div class="mui-input-row" style="height: 60px;">
						<label style="position: absolute; top: 12px;font-size:0.9em;">昵称</label>
						<input type="text"value="<?php echo $result['fullname']; ?>" name="truename" style="margin-top: 10px;font-size:0.9em;margin-right:-130px;"placeholder="请输入您的昵称">
					</div>
					<div class="mui-input-row" style="height: 60px;">
						<label style="position: absolute; top: 12px;font-size:0.9em;">支付宝</label>
						<input type="number"value="<?php if($result['aiplay'] != '0'): ?><?php echo $result['aiplay']; endif; ?>"  <?php if($result['aiplay'] != '0'): ?>readonly="readonly"<?php else: ?>class="mui-input-clear"<?php endif; ?> name="zhifubao" style="margin-right:-130px;margin-top: 10px;font-size:0.9em;"placeholder="请输入支付宝帐号">
					</div>
					<div class="mui-input-row" style="height: 60px;">
						<label style="position: absolute; top: 12px;font-size:0.9em;">微信</label>
						<input type="number"value="<?php if($result['weixin'] != '0'): ?><?php echo $result['weixin']; endif; ?>"  <?php if($result['weixin'] != '0'): ?>readonly="readonly"<?php else: ?>class="mui-input-clear"<?php endif; ?>  name="weixin" style="margin-right:-130px;margin-top: 10px;font-size:0.9em;"placeholder="请输入微信账号">
					</div>
					<!--<div class="mui-input-row"style="height: 60px;">
						<label style="position: absolute; top: 12px;font-size:0.9em;">性别</label>
						<input type="text" style="margin-top: 10px;font-size:0.9em;" placeholder="男/女">
					</div>-->
					<ul class="mui-table-view">
				<li class="mui-table-view-cell"style="line-height: 2em;">
					<a class="mui-navigate-right" style="font-size:0.9em;">
						等级信息
					</a>
				</li>
		</ul>
					<div class="mui-input-row">
						<label style="position: absolute; top: 12px;font-size:0.9em;">验证</label>
						<input type="number" style="margin-top: 10px;font-size:0.9em;" class="mui-input-clear" placeholder="请输入验证码" name="sms_code">
					</div>
					<input type="button" style="position: absolute; background: #957afd; color: #fff; margin-top: -30px; right: 15px;  font-size: 0.8em; border-radius: 15px; width: 30%;" id="code"  value="获取验证码">
		<br>
					<div class="mui-button-row">
						<button type="button" class="mui-btn mui-btn-primary" style="background:#957afd; color:#fff;border-radius: 30px; line-height: 2; width: 90%; margin-bottom:150px;" id="submit">提交</button>
					</div>	
					</div>	
		</form>
		
		<script>
			mui.init({
				swipeBack: true //启用右滑关闭功能
			});
			(function($) {
				//监听点击事件
				document.getElementById("code").addEventListener('tap',function(){
					console.log(11111);
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
						timeout:50000,//超时时间设置为50秒；
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
					var truename = $("input[name=truename]")[0].value;
					var username = $("input[name=username]")[0].value;
					
					var weixin = $("input[name=weixin]")[0].value;
					var zhifubao = $("input[name=zhifubao]")[0].value;
					//var eth_url = $("input[name=eth_url]")[0].value;
					
					var mobile = $("input[name=mobile]")[0].value;
					var sms_code = $("input[name=sms_code]")[0].value;
					
				//	var password = $("input[name=password]")[0].value;

					//console.log(mobile);return false;
					if(!username){
						alert('请输入用户名！');return false;
					}

					if(!mobile){
						alert('请输入手机号码！');return false;
					}
					if(!sms_code){
						alert('请输入验证码！');return false;
					}
						
					$.ajax('/edit_info.html',{
						data:{truename:truename,username:username,weixin:weixin,zhifubao:zhifubao,mobile:mobile,sms_code:sms_code,password:password},
						dataType:'json',//服务器返回json格式数据
						type:'post',//HTTP请求类型
						timeout:50000,//超时时间设置为50秒；
						/*headers:{'Content-Type':'application/json'},*/	              
						success:function(data){
							if(data.s=='ok'){
								alert('修改成功');
								window.location.href = "/myziliao.html";
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