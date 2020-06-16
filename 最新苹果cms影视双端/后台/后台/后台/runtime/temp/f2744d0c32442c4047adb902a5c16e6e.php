<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:39:"template/default_pc/html/user/info.html";i:1582533410;s:68:"/www/wwwroot/qy.redlk.com/template/default_pc/html/user/include.html";i:1582533410;s:65:"/www/wwwroot/qy.redlk.com/template/default_pc/html/user/head.html";i:1582533410;s:65:"/www/wwwroot/qy.redlk.com/template/default_pc/html/user/foot.html";i:1582533410;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>修改资料 - 会员中心 - <?php echo $maccms['site_name']; ?></title>
	<meta name="keywords" content="">
	<meta name="description" content="">
	<link href="<?php echo $maccms['path']; ?>static/css/home.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $maccms['path_tpl']; ?>css/member.css" type="text/css" rel="stylesheet" />
<script src="<?php echo $maccms['path_tpl']; ?>js/tab.js" type="text/javascript"></script>
<script src="<?php echo $maccms['path']; ?>static/js/jquery.js"></script>
<script src="<?php echo $maccms['path']; ?>static/js/jquery.lazyload.js"></script>
<script src="<?php echo $maccms['path']; ?>static/js/jquery.autocomplete.js"></script>
<script src="<?php echo $maccms['path_tpl']; ?>js/jquery.superslide.js"></script>
<script src="<?php echo $maccms['path_tpl']; ?>js/jquery.lazyload.js"></script>
<script>var maccms={"path":"","mid":"<?php echo $maccms['mid']; ?>","url":"<?php echo $maccms['site_url']; ?>","wapurl":"<?php echo $maccms['site_wapurl']; ?>","mob_status":"<?php echo $maccms['mob_status']; ?>"};</script>
<script src="<?php echo $maccms['path']; ?>static/js/home.js"></script>
<script src="<?php echo $maccms['path_tpl']; ?>js/formValidator-4.0.1.js" type="text/javascript"></script>
<script src="<?php echo $maccms['path']; ?>static/js/jquery.imageupload.js"></script>

</head>
<body>
<div class="header">
	<div class="layout fn-clear">
		<div class="logo">
			<a href="<?php echo $maccms['path']; ?>"><img width="157" height="42" src="<?php echo $maccms['path_tpl']; ?>images/member/ilogo.gif" alt=""/></a>
		</div>
		<ul class="nav">
			<li class="nav-item"><a class="nav-link" href="<?php echo $maccms['path']; ?>">返回首页</a></li>
			<li class="nav-item" ><a class="nav-link"><?php echo $obj['user_name']; ?></a></li>
			<li class="nav-item" ><a class="nav-link" href="<?php echo url('user/logout'); ?>" >退出</a></li>
		</ul>
	</div>
</div>
<!-- // i-header end -->


<!-- 会员中心 -->
<div id="member" class="fn-clear">
	<div id="left">
		<div class="tou"><img src="<?php echo mac_url_img(mac_default($obj['user_portrait'],'static/images/touxiang.png')); ?>" alt="会员头像"><p><?php echo $obj['user_name']; ?><br /><?php echo $obj['group']['group_name']; ?></p></div>
		<ul>
			<li class="hover"><a href="<?php echo url('user/index'); ?>">我的资料</a></li>
			<li><a href="<?php echo url('user/favs'); ?>">我的收藏</a></li>
			<li><a href="<?php echo url('user/plays'); ?>">播放记录</a></li>
			<li><a href="<?php echo url('user/downs'); ?>">下载记录</a></li>
			<li><a href="<?php echo url('user/buy'); ?>">在线充值</a></li>
			<li><a href="<?php echo url('user/upgrade'); ?>">升级会员</a></li>
			<li><a href="<?php echo url('user/orders'); ?>">充值记录</a></li>
			<li><a href="<?php echo url('user/cash'); ?>">提现记录</a></li>
			<li><a href="<?php echo url('user/reward'); ?>">三级分销</a></li>
		</ul>
	</div>
	<div id="right">
		<h2>我的资料</h2>
		<div id="tab">
			<div class="list">
				<ul class="fn-clear">
					<li><a href="<?php echo url('user/index'); ?>">基本资料</a></li>
					<li class="cur">修改信息</li>
					<li><a href="<?php echo url('user/popedom'); ?>">我的权限</a></li>
				</ul>
			</div>
			<div id="listCon">

				<!-- 修改信息 -->
				<div class="cur">
					<form id="fm" name="fm" method="post" action="" >
					<p><span class="xiang">用户名：</span><?php echo $obj['user_name']; ?></p>
					<p><span class="xiang">昵称：</span><input type="text" name="user_nick_name" class="member-input" value="<?php echo $obj['user_nick_name']; ?>"></p>
					<p><span class="xiang">原始密码：</span><input type="password" name="user_pwd" class="member-input"></p>
					<p><span class="xiang">新密码：</span><input type="password" name="user_pwd1" class="member-input"><span class="tishi">不修改请留空</span></p>
					<p><span class="xiang">重复密码：</span><input type="password" name="user_pwd2" class="member-input"></p>
					<p><span class="xiang">QQ号码：</span><input type="text" name="user_qq" class="member-input" value="<?php echo $obj['user_qq']; ?>"></p>
					<?php if($obj['user_email'] != ''): ?>
						<p><span class="xiang">邮箱：</span><input type="text" name="user_email" class="member-input" readonly="readonly" value="<?php echo $obj['user_email']; ?>">[<a class="btn_unbind" ac="email" href="javascript:;">解绑</a>]</p>
					<?php else: ?>
						<p><span class="xiang">邮箱：</span><input type="text" name="user_email" class="member-input" value="">[<a href="<?php echo url('user/bind'); ?>?ac=email">绑定</a>]</p>
					<?php endif; if($obj['user_phone'] != ''): ?>
						<p><span class="xiang">手机：</span><input type="text" name="user_phone" class="member-input" readonly="readonly" value="<?php echo $obj['user_phone']; ?>">[<a class="btn_unbind" ac="phone" href="javascript:;">解绑</a>]</p>
						<?php else: ?>
						<p><span class="xiang">手机：</span><input type="text" name="user_phone" class="member-input" value="">[<a href="<?php echo url('user/bind'); ?>?ac=phone">绑定</a>]</p>
						<?php endif; ?>

					<p><span class="xiang">找回密码问题：</span><input type="text" name="user_question" class="member-input" value="<?php echo $obj['user_question']; ?>"></p>
					<p><span class="xiang">找回密码答案：</span><input type="text" name="user_answer" class="member-input" value="<?php echo $obj['user_answer']; ?>"></p>
					<p><span class="xiang"></span><input type="button" id="btn_submit" class="search-button" value="保存"><span class="wjmm"><a href="<?php echo url('user/findpass'); ?>">忘记密码了？</a></span></p>
					<p><span class="xiang"></span></p>
					</form>
				</div>

			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

	$('.btn_unbind').click(function(){
		var ac = $(this).attr('ac');
		if(ac!='email' && ac!='phone'){
			alert('参数错误');
		}
		if(confirm('确认解除绑定吗？此操作不可恢复？')) {
			$.ajax({
				url: "<?php echo url('user/unbind'); ?>",
				type: "post",
				dataType: "json",
				data: {ac: ac},
				beforeSend: function () {
					//开启loading
				},
				success: function (r) {
					alert(r.msg);
					if(r.code==1){
						location.href="<?php echo url('user/info'); ?>";
					}
				},
				complete: function () {
					//结束loading
				}
			});
		}
	});

	$("#btn_submit").click(function() {
		var data = $("#fm").serialize();
		$.ajax({
			url: "<?php echo url('user/info'); ?>",
			type: "post",
			dataType: "json",
			data: data,
			beforeSend: function () {
				//开启loading
				//$(".loading_box").css("display","block");
				$("#btn_submit").css("background","#fd6a6a").val("loading...");
			},
			success: function (r) {
				alert(r.msg);
				if(r.code==1){
					location.href="<?php echo url('user/info'); ?>";
				}
			},
			complete: function () {
				//结束loading
				//$(".loading_box").css("display","none");
				$("#btn_submit").css("background","#fa4646").val("提交");
			}
		});
	});

</script>
<!-- // sign-content end -->
<div class="footer">
	<div class="layout">
		<div class="foot-nav">
			<a href="{maccms:link_gbook}" target="_blank" title="给我留言">给我留言</a>-<a href="{maccms:link_map_vod}" target="_blank" title="网站地图">网站地图</a>-<a href="{maccms:link_map_rss}" target="_blank" title="RSS订阅">RSS订阅</a>-<a href="{maccms:link_map_baidu}" target="_blank" title="BaiduRSS">BaiduRSS</a>-<a href="{maccms:link_map_google}" target="_blank" title="GoogleRSS">GoogleRSS</a>
		</div>
		<!-- // foot-nav End -->
		<div class="copyright">
			<p>
				本网站提供的最新电视剧和电影资源均系收集于各大视频网站，本网站只提供web页面服务，并不提供影片资源存储，也不参与录制、上传
			</p>
			<p>
				若本站收录的节目无意侵犯了贵司版权，请给网页底部邮箱地址来信，我们会及时处理和回复，谢谢
			</p>
			<p>
				Copyright &copy; 2008-2018 <a class="color" href="http://<?php echo $maccms['site_url']; ?>"><?php echo $maccms['site_name']; ?><?php echo $maccms['site_url']; ?></a>
			</p>
		</div>
		<!-- // maxBox End -->
	</div>
</div>
<!-- // footer end -->
</body>
</html>