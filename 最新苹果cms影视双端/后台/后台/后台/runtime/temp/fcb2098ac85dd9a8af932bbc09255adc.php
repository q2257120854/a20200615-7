<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:42:"template/conch/html/user/findpass_msg.html";i:1569607018;s:63:"/www/wwwroot/qy.redlk.com/template/conch/html/user/include.html";i:1569640448;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>找回密码 - <?php echo $maccms['site_name']; ?> </title>
	<meta name="keywords" content="<?php echo $maccms['site_keywords']; ?>"/>
	<meta name="description" content="<?php echo $maccms['site_description']; ?>"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE10" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<?php $conch = file_exists('application/extra/hltheme.php') ? require('application/extra/hltheme.php') : require(substr($maccms['path_tpl'], strlen($maccms['path'])).'asset/admin/hltheme.php'); ?>
<link rel="shortcut icon" href="<?php echo $maccms['path_tpl']; ?>asset/img/favicon.png" type="image/x-icon" />
<link href="<?php echo $maccms['path_tpl']; ?>asset/css/member/member.conch.css" type="text/css" rel="stylesheet" />
<script src="<?php echo $maccms['path']; ?>static/js/jquery.js"></script>
<script src="<?php echo $maccms['path']; ?>static/js/jquery.autocomplete.js"></script>
<script src="<?php echo $maccms['path_tpl']; ?>asset/js/hlhtml.js"></script>
<script src="<?php echo $maccms['path_tpl']; ?>asset/js/member/jquery.superslide.js"></script>
<script src="<?php echo $maccms['path_tpl']; ?>asset/js/member/system.hl.user.js"></script>
<script>var maccms={"path":"","mid":"<?php echo $maccms['mid']; ?>","url":"<?php echo $maccms['site_url']; ?>","wapurl":"<?php echo $maccms['site_wapurl']; ?>","mob_status":"<?php echo $maccms['mob_status']; ?>"};</script>
<script src="<?php echo $maccms['path']; ?>static/js/home.js"></script>
<script src="<?php echo $maccms['path_tpl']; ?>asset/js/member/formValidator-4.0.1.js" type="text/javascript"></script>
<script src="<?php echo $maccms['path']; ?>static/js/jquery.imageupload.js"></script>

</head>
<body id="reg">
	<div class="reg-w">
	    <div class="reg-logo">
			<a title="<?php echo $maccms['site_name']; ?>" style="background-image: url(<?php echo mac_url_img(mac_default($conch['theme']['logo']['bpic'],substr($maccms['path_tpl'], strlen($maccms['path'])).'asset/img/logo_black.png')); ?>);" href="<?php echo $maccms['path']; ?>"></a>
		</div>
		<form method="post" id="fm" action="">
			<input type="hidden" name="ac" value="<?php echo $param['ac']; ?>">
			<h4><?php echo $param['ac_text']; ?>找回密码</h4>
			<div class="reg-group">
				<label class="bd-r" style="letter-spacing: normal;"><?php echo $param['ac_text']; ?></label><input type="text" id="to" name="to" class="reg-control" placeholder="请输入您绑定的<?php echo $param['ac_text']; ?>">
			</div>

			<div class="reg-group">
				<label>验证码</label><input type="text" class="reg-control w150" id="verify" name="verify" placeholder="请输入验证码">
				<img class="fr m-hi" src="<?php echo url('verify/index'); ?>" onClick="this.src=this.src+'?'"  alt="单击刷新" />
			</div>
			<input type="button" id="btn_send" class="btn-brand btn-sub" value="发送验证码">
		</form>

		<form method="post" id="fm2" action="">
			<input type="hidden" name="ac" value="email">
			<h4>验证信息</h4>
			<div class="reg-group">
				<label class="bd-r" style="letter-spacing: normal;">验证码</label><input type="text" id="code" name="code" class="reg-control" placeholder="请输入<?php echo $param['ac_text']; ?>收到的验证码">
			</div>
			<div class="reg-group">
				<label>新密码</label><input type="password" class="reg-control w150" id="user_pwd" name="user_pwd" placeholder="请输入新密码">
			</div>
			<div class="reg-group">
				<label>确认密码</label><input type="password" class="reg-control w150" id="user_pwd2" name="user_pwd2" placeholder="请输入确认密码">
			</div>
			<input type="button" id="btn_submit" class="btn-brand btn-sub" value="重置密码">
		</form>
        <div class="reg-ts">
    	<a href="<?php echo url('user/login'); ?>">登录账号</a><a href="<?php echo url('user/findpass'); ?>">用密保找回</a><?php if($_GET['ac']=='phone'): ?><a href="<?php echo url('user/findpass_msg'); ?>?ac=email">用邮箱找回</a><?php elseif($_GET['ac']=='email'): ?><a href="<?php echo url('user/findpass_msg'); ?>?ac=phone">用手机找回</a><?php endif; ?>
        </div>
	</div>

<!-- // sign-box#regbox end -->
<script type="text/javascript">

	$(function(){
		$("body").bind('keyup',function(event) {
			if(event.keyCode==13){ $('#btnLogin').click(); }
		});
		$('#btn_send').click(function() {
			if ($('#to').val()  == '') { alert('请输入<?php echo $param["ac_text"]; ?>！'); $("#to").focus(); return false; }

			$.ajax({
				url: "<?php echo url('user/findpass_msg'); ?>",
				type: "post",
				dataType: "json",
				data: $('#fm').serialize(),
				beforeSend: function () {
					$("#btn_send").css("background","#fd6a6a").val("loading...");
				},
				success: function (r) {
					alert(r.msg);
				},
				complete: function () {
					$('#verify').click();
					$("#btn_send").css("background","#fa4646").val("发送邮件");
				}
			});
		});

		$('#btn_submit').click(function() {
			if ($('#to').val()  == '') { alert('请输入<?php echo $param["ac_text"]; ?>'); $("#to").focus(); return false; }
			if ($('#code').val()  == '') { alert('请输入验证码！'); $("#code").focus(); return false; }
			if ($('#user_pwd').val()  == '') { alert('请输入新密码！'); $("#user_pwd").focus(); return false; }
			if ($('#user_pwd2').val()  == '') { alert('请输入确认密码！'); $("#user_pwd2").focus(); return false; }
			if ($('#user_pwd').val()  != $('#user_pwd2').val() ) { alert('二次密码不一致！'); $("#user_pwd2").focus(); return false; }

			var data= {ac:'<?php echo $param["ac"]; ?>',to:$('#to').val(),code:$('#code').val(),user_pwd:$('#user_pwd').val(),user_pwd2:$('#user_pwd2').val()};
			$.ajax({
				url: "<?php echo url('user/findpass_reset'); ?>",
				type: "post",
				dataType: "json",
				data: data,
				beforeSend: function () {
					$("#btn_submit").css("background","#fd6a6a").val("loading...");
				},
				success: function (r) {
					alert(r.msg);
				},
				complete: function () {
					$("#btn_submit").css("background","#fa4646").val("重置密码");
				}
			});
		});
	});

</script>
<div class="footer">
	<div class="layout">
		<div class="copyright">
			<p>&copy; <?php echo date('Y'); ?> <a class="color" href="//<?php echo $maccms['site_url']; ?>"><?php echo $maccms['site_url']; ?></a>  All Rights Reserved.</p>
		</div>
	</div>
</div>
</body>
</html>