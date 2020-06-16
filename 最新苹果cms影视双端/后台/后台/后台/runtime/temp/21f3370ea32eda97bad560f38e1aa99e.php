<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:33:"template/conch/html/user/reg.html";i:1569607018;s:63:"/www/wwwroot/qy.redlk.com/template/conch/html/user/include.html";i:1569640448;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>用户注册 - <?php echo $maccms['site_name']; ?></title>
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
			<h4>用户注册</h4>
			<div class="reg-group">
				<label class="bd-r" style="letter-spacing: normal;">账号</label><input type="text" id="user_name" name="user_name" class="reg-control" placeholder="请输入您的登录账号">
			</div>
			<div class="reg-group">
				<label>密码</label><input type="password" id="user_pwd" name="user_pwd" class="reg-control" placeholder="请输入您的登录密码">
			</div>
			<div class="reg-group">
				<label>确认密码</label><input type="password" id="user_pwd2" name="user_pwd2" class="reg-control" placeholder="请输入您的确认密码">
			</div>
			<?php if($user_config['reg_phone_sms'] != 0): ?>
			<input type="hidden" name="ac" value="phone">
			<div class="reg-group">
				<label>手机号码</label><input type="text" class="reg-control w150" id="to" name="to" placeholder="请输入手机号">
				<input type="button" class="fr m-hi reg-yzm" id="btn_send_sms" value="获取验证码"/>
			</div>
			<div class="reg-group">
				<label>验证码</label><input type="text" class="reg-control" id="code" name="code" placeholder="请输入手机验证码">
			</div>
			<?php elseif($user_config['reg_email_sms'] != 0): ?>
			<input type="hidden" name="ac" value="email">
			<div class="reg-group">
				<label>邮箱地址</label><input type="text" class="reg-control w150" id="to" name="to" placeholder="请输入邮箱">
				<input type="button" class="fr m-hi reg-yzm" id="btn_send_sms" value="获取验证码"/>
			</div>
			<div class="reg-group">
				<label>验证码</label><input type="text" class="reg-control" id="code" name="code" placeholder="请输入邮箱验证码">
			</div>
			<?php endif; if($user_config['reg_verify'] != 0): ?>
			<div class="reg-group">
				<label>验证码</label><input type="text" class="reg-control w150" id="verify" name="verify" placeholder="请输入验证码">
				<img class="fr m-hi" id="verify_img" src="<?php echo url('verify/index'); ?>" onClick="this.src=this.src+'?'"  alt="单击刷新" />
			</div>
			<?php endif; ?>
			<input type="button" id="btn_submit" class="btn-brand btn-sub" value="立即注册">
		</form>
	<div class="reg-ts">
   	    <a href="<?php echo $maccms['path']; ?>">返回首页</a><a href="<?php echo url('user/login'); ?>">登录账号</a><a href="<?php echo url('user/findpass'); ?>">忘记密码</a>
    </div>
	</div>

<!-- // sign-box#regbox end -->
<script type="text/javascript">

    var countdown=60;
    function settime(val) {
        if (countdown == 0) {
            val.removeAttribute("disabled");
            val.value="获取验证码";
            countdown = 60;
            return true;
        } else {
            val.setAttribute("disabled", true);
            val.value="重新发送(" + countdown + ")";
            countdown--;
        }
        setTimeout(function() {settime(val) },1000)
    }


		$("body").bind('keyup',function(event) {
			if(event.keyCode==13){ $('#btnLogin').click(); }
		});

        $('#btn_send_sms').click(function(){
            var ac = $('input[name="ac"]').val();
            var to = $('input[name="to"]').val();
            if(ac=='email') {
                var pattern = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
                var ex = pattern.test(to);
                if (!ex) {
                    alert('邮箱格式不正确');
                    return;
                }
            }
            else if(ac=='phone') {
                var pattern=/^[1][0-9]{10}$/;
                var ex = pattern.test(to);
                if (!ex) {
                    alert('手机号格式不正确');
                    return;
                }
            }
            else{
                alert('参数错误');
                return;
            }


            settime(this);
            var data = $("#fm").serialize();

            $.ajax({
                url: "<?php echo url('user/reg_msg'); ?>",
                type: "post",
                dataType: "json",
                data: data,
                beforeSend: function () {
                    //开启loading
                },
                success: function (r) {
                    alert(r.msg);
                },
                complete: function () {
                    //结束loading
                }
            });
        });

		$('#btn_submit').click(function() {
			if ($('#user_name').val()  == '') { alert('请输入用户！'); $("#user_name").focus(); return false; }
			if ($('#user_pwd').val()  == '') { alert('请输入密码！'); $("#user_pwd").focus(); return false; }
			if ($('#verify').val()  == '') { alert('请输入验证码！'); $("#verify").focus(); return false; }

			$.ajax({
				url: "<?php echo url('user/reg'); ?>",
				type: "post",
				dataType: "json",
				data: $('#fm').serialize(),
				beforeSend: function () {
					$("#btn_submit").css("background","#fd6a6a").val("loading...");
				},
				success: function (r) {
					alert(r.msg);
					if(r.code==1){
						location.href="<?php echo url('user/login'); ?>";
					}
					else{
						$('#verify_img').click();
					}
				},
				complete: function () {
					$("#btn_submit").css("background","#fa4646").val("立即注册");
				}
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