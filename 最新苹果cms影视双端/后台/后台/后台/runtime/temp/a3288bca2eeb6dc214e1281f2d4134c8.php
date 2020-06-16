<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:40:"template/default_pc/html/user/index.html";i:1582533410;s:68:"/www/wwwroot/qy.redlk.com/template/default_pc/html/user/include.html";i:1582533410;s:65:"/www/wwwroot/qy.redlk.com/template/default_pc/html/user/head.html";i:1582533410;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>会员中心 - <?php echo $maccms['site_name']; ?></title>
	<meta name="keywords" content="会员中心">
	<meta name="description" content="会员中心">
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
		<div class="tou"><img class="face" src="<?php echo mac_url_img(mac_default($obj['user_portrait'],'static/images/touxiang.png')); ?>" alt="会员头像"><p><?php echo $obj['user_name']; ?><br /><?php echo $obj['group']['group_name']; ?></p></div>
		<ul>
			<li class="hover"><a href="<?php echo url('user/index'); ?>">我的资料</a></li>
			<li><a href="<?php echo url('user/favs'); ?>">我的收藏</a></li>
			<li><a href="<?php echo url('user/plays'); ?>">播放记录</a></li>
			<li><a href="<?php echo url('user/downs'); ?>">下载记录</a></li>
			<li><a href="<?php echo url('user/buy'); ?>">在线充值</a></li>
			<li><a href="<?php echo url('user/upgrade'); ?>">升级会员</a></li>
			<li><a href="<?php echo url('user/orders'); ?>">充值记录</a></li>
			<li><a href="<?php echo url('user/plog'); ?>">积分记录</a></li>
			<li><a href="<?php echo url('user/cash'); ?>">提现记录</a></li>
			<li><a href="<?php echo url('user/reward'); ?>">三级分销</a></li>
		</ul>
	</div>
	<div id="right">
		<h2>我的资料</h2>
		<div id="tab">
			<div class="list">
				<ul class="fn-clear">
					<li class="cur">基本资料</li>
					<li><a href="<?php echo url('user/info'); ?>">修改信息</a></li>
					<li><a href="<?php echo url('user/popedom'); ?>">我的权限</a></li>
				</ul>
			</div>
			<div id="listCon">
				<!-- 基本资料 -->
				<div class="cur">
					<p><span class="xiang">用户名：</span><?php echo $obj['user_name']; ?></p>
					<p><span class="xiang">所属会员组：</span><?php echo $obj['group']['group_name']; ?></p>
					<p><span class="xiang">会员期限：</span><?php echo mac_day($obj['user_end_time']); ?></p>
					<p><span class="xiang">QQ号码：</span><?php echo $obj['user_qq']; ?></p>
					<p><span class="xiang">Email地址：</span><?php echo $obj['user_email']; ?></p>
					<p><span class="xiang">注册时间：</span><?php echo mac_day($obj['user_reg_time']); ?></p>
					<p><span class="xiang">登陆IP：</span><?php echo long2ip($obj['user_login_ip']); ?></p>
					<p><span class="xiang">登陆时间：</span><?php echo mac_day($obj['user_login_time']); ?></p>
					<p><span class="xiang">账户积分：</span><?php echo $obj['user_points']; ?></p>
					<?php if($GLOBALS['config']['user']['invite_reg_points'] > 0): ?>
					<p><span class="xiang">推广注册链接：</span>
						<input id="url" class="member-input" value="<?php echo $maccms['http_type']; ?><?php echo $maccms['site_url']; ?><?php echo mac_url('user/reg'); ?>?uid=<?php echo $obj['user_id']; ?>" size="70" style="width:500px;">
					</p>
					<?php endif; if($GLOBALS['config']['user']['invite_visit_points'] > 0): ?>
					<p><span class="xiang">推广访问链接：</span>
						<input id="url2" class="member-input" value="<?php echo $maccms['http_type']; ?><?php echo $maccms['site_url']; ?><?php echo mac_url('user/visit'); ?>?uid=<?php echo $obj['user_id']; ?>" size="70" style="width:500px;">
					</p>
					<?php endif; ?>
				</div>
				<!-- 修改信息 -->
				<div>
					<p><span class="xiang">用户名：</span>wen123</p>
					<p><span class="xiang">新密码：</span><input type="password" name="" class="member-input"><span class="tishi"><img src="images/dui.png" alt="正确">输入正确</span></p>
					<p><span class="xiang">重复密码：</span><input type="password" name="" class="member-input"><span class="tishi"><img src="images/dui.png" alt="正确">输入正确</span></p>
					<p><span class="xiang">QQ号码：</span><input type="text" name="" class="member-input"><span class="tishi"><img src="images/dui.png" alt="正确">输入正确</span></p>
					<p><span class="xiang">邮件地址：</span><input type="text" name="" class="member-input"><span class="tishi"><img src="images/dui.png" alt="正确">输入正确</span></p>
					<p><span class="xiang">联系电话：</span><input type="text" name="" class="member-input"><span class="tishi"><img src="images/dui.png" alt="正确">输入正确</span></p>
					<p><span class="xiang">找回密码问题：</span><input type="text" name="" class="member-input"><span class="tishi"><img src="images/dui.png" alt="正确">输入正确</span></p>
					<p><span class="xiang">找回密码答案：</span><input type="text" name="" class="member-input"><span class="tishi"><img src="images/cuo.png" alt="错误">输入错误</span></p>
					<p><span class="xiang"></span><input type="submit" class="search-button" value="保存"><span class="wjmm"><a href="">忘记密码了？</a></span></p>
					<p><span class="xiang"></span><span class="tishi2"><img src="images/dui.png" alt="正确">输入正确</span></p>
				</div>
				<!-- 我的权限 -->
				<div>
					<p><span class="xiang">用户名：</span>wen123</p>
					<p><span class="xiang">用户组：</span><span class="fen">VIP会员</span></p>
					<p><span class="xiang">权限列表：</span>绿色表示用户有访问权限，灰色表示无访问权限，若你想要提升访问权限可选择升级会员组</p>
					<p><span class="quanxian">电影</span><span class="you">列表页</span><span class="wu">内容页</span><span class="you">播放页</span><span class="you">下载页</span></p>
					<p><span class="quanxian">喜剧片</span><span class="you">列表页</span><span class="wu">内容页</span><span class="you">播放页</span><span class="you">下载页</span></p>
					<p><span class="quanxian">爱情片</span><span class="you">列表页</span><span class="wu">内容页</span><span class="you">播放页</span><span class="you">下载页</span></p>
					<p><span class="quanxian">剧情片</span><span class="you">列表页</span><span class="wu">内容页</span></p>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(".face").imageUpload({
		formAction: "<?php echo url('user/portrait'); ?>",
		inputFileName:'file',
		browseButtonValue: '修改头像',
		browseButtonClass:'btn btn-default btn-xs',
		automaticUpload: true,
		hideDeleteButton: true,
		hover:true
	})
	$(".face").on("imageUpload.uploadFailed", function (ev, err) {
		alert(err);
	});
</script>

</body>
</html>