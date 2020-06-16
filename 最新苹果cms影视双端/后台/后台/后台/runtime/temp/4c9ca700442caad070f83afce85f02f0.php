<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:38:"template/default_pc/html/user/buy.html";i:1582533410;s:68:"/www/wwwroot/qy.redlk.com/template/default_pc/html/user/include.html";i:1582533410;s:65:"/www/wwwroot/qy.redlk.com/template/default_pc/html/user/head.html";i:1582533410;s:65:"/www/wwwroot/qy.redlk.com/template/default_pc/html/user/foot.html";i:1582533410;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>充值卡充值 - 会员中心 -<?php echo $maccms['site_name']; ?></title>
<meta name="keywords" content="<?php echo $maccms['site_keywords']; ?>"/>
<meta name="description" content="<?php echo $maccms['site_description']; ?>"/>
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
			<li><a href="<?php echo url('user/index'); ?>">我的资料</a></li>
			<li><a href="<?php echo url('user/favs'); ?>">我的收藏</a></li>
			<li><a href="<?php echo url('user/plays'); ?>">播放记录</a></li>
			<li><a href="<?php echo url('user/downs'); ?>">下载记录</a></li>
			<li class="hover"><a href="<?php echo url('user/buy'); ?>">在线充值</a></li>
			<li><a href="<?php echo url('user/upgrade'); ?>">升级会员</a></li>
			<li><a href="<?php echo url('user/orders'); ?>">充值记录</a></li>
			<li><a href="<?php echo url('user/cash'); ?>">提现记录</a></li>
			<li><a href="<?php echo url('user/reward'); ?>">三级分销</a></li>
		</ul>
	</div>
    <div id="right">
		<h2>在线充值</h2>
		<div class="line40">
			<p><span class="xiang">剩余积分：</span><?php echo $obj['user_points']; ?></p>
			<p><span class="xiang">充值的金额：</span><input type="text" name="price" value="<?php echo $config['min']; ?>" class="jifen-input"></p>
			<p><input type="button" id="btn_submit_pay" class="jifen2-button" value="确认"></p>
			<p class="hui">友情提示：最小充值金额为<?php echo $config['min']; ?>元，1元可以兑换<?php echo $config['scale']; ?>个积分</p>
		</div>

		<div class="line40">
			<p><span class="xiang">充值卡号：</span><input type="text" name="card_no" value="" class="jifen-input">
				<?php if($GLOBALS['config']['pay']['card']['url'] != ''): ?>
				<a target="_blank" href="<?php echo $GLOBALS['config']['pay']['card']['url']; ?>">点击购买卡密</a>
				<?php endif; ?>
			</p>
			<p><span class="xiang">充值密码：</span><input type="text" name="card_pwd" value="" class="jifen-input"></p>
			<p><input type="button" id="btn_submit_card" class="jifen2-button" value="确认"></p>
			<p class="hui">友情提示：请到卡密平台购买充值卡</p>
		</div>
    </div>
</div>
<script>

	$(".go-back").click(function () {
		var ref = document.referrer;
		location.href=ref;
	});

	$('#btn_submit_pay').click(function(){
		var that=$(this);
		var price = $("input[name='price']").val();
		if(Number(price)<1){
			return;
		}
		if(confirm('确定要在线充值吗')) {
			$.ajax({
				url: "<?php echo url('user/buy'); ?>",
				type: "post",
				dataType: "json",
				data: {price: price,flag:'pay'},
				beforeSend: function () {
					$("#btn_submit_pay").css("background","#fd6a6a").val("loading...");
				},
				success: function (r) {
					if (r.code == 1) {
						location.href="<?php echo url('user/pay'); ?>?order_code=" + r.data.order_code;
					}
					else{
						alert(r.msg);
					}
				},
				complete: function () {
					$("#btn_submit_pay").css("background","#fa4646").val("提交");
				}
			});
		}
	});

	$('#btn_submit_card').click(function(){
		var that=$(this);
		var no = $('input[name="card_no"]').val();
		var pwd = $('input[name="card_pwd"]').val();
		if(no=='' || pwd==''){
			alert('请输入充值卡号和密码');
			return;
		}
		if(confirm('确定要使用充值卡充值吗')) {
			$.ajax({
				url: "<?php echo url('user/buy'); ?>",
				type: "post",
				dataType: "json",
				data: {card_no: no,card_pwd:pwd,flag:'card'},
				beforeSend: function () {
					$("#btn_submit_card").css("background","#fd6a6a").val("loading...");
				},
				success: function (r) {
					alert(r.msg);
				},
				complete: function () {
					$("#btn_submit_card").css("background","#fa4646").val("提交");
				}
			});
		}
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