<?php if (!defined('THINK_PATH')) exit(); /*a:9:{s:35:"template/conch/html/user/index.html";i:1568888418;s:63:"/www/wwwroot/qy.redlk.com/template/conch/html/user/include.html";i:1569640448;s:60:"/www/wwwroot/qy.redlk.com/template/conch/html/user/head.html";i:1569607018;s:64:"/www/wwwroot/qy.redlk.com/template/conch/html/user/left_nav.html";i:1568826750;s:63:"/www/wwwroot/qy.redlk.com/template/conch/html/ads/ads_user.html";i:1569607056;s:60:"/www/wwwroot/qy.redlk.com/template/conch/html/user/foot.html";i:1569607056;s:66:"/www/wwwroot/qy.redlk.com/template/conch/html/widget/foot_nav.html";i:1574604176;s:63:"/www/wwwroot/qy.redlk.com/template/conch/html/widget/icon2.html";i:1569607056;s:62:"/www/wwwroot/qy.redlk.com/template/conch/html/widget/icon.html";i:1569607056;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>会员中心 - <?php echo $maccms['site_name']; ?></title>
	<meta name="keywords" content="会员中心">
	<meta name="description" content="会员中心">
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
<body id="uindex">
<div class="header">
	<div class="layout fn-clear">
	    <div class="user-logo">
			<a title="<?php echo $maccms['site_name']; ?>" style="background-image: url(<?php echo mac_url_img(mac_default($conch['theme']['logo']['wpic'],substr($maccms['path_tpl'], strlen($maccms['path'])).'asset/img/logo_white.png')); ?>);" href="<?php echo $maccms['path']; ?>"></a>
		</div>
		<div class="user-n"><span>个人中心</span></div>
		<ul class="nav">
		    <li class="nav-item"><a class="nav-link" href="javascript:MAC.GoBack()">返回</a></li>
			<li class="nav-item"><a class="nav-link" href="<?php echo $maccms['path']; ?>">返回首页</a></li>
			<li class="nav-item" ><a class="nav-link"><?php echo $obj['user_name']; ?></a></li>
			<li class="nav-item" ><a class="nav-link" href="<?php echo url('user/logout'); ?>" >退出</a></li>
		</ul>
	</div>
</div>
<!-- // i-header end -->


<!-- 会员中心 -->
<div id="member" class="fn-clear">
	<div id="left" class="dl-bl">
	    <div id="ui-nav" class="m-nav">
			<a href="javascript:MAC.GoBack()" class="btn-left"><i class="iconfont ico-right">&#xe625;</i></a>
			<a href="<?php echo $maccms['path']; ?>" class="btn-right"><i class="iconfont ico-right">&#xe634;</i></a>
			<span class="mb-title">个人中心</span>
	    </div>
		    <div class="tou">
			<div class="tou-left">
				<img class="face" src="<?php echo mac_url_img(mac_default($obj['user_portrait'],'static/images/touxiang.png')); ?>" alt="会员头像">
			</div>
			<div class="tou-right">
				<span class="name-tit"><?php echo $obj['user_name']; ?></span>
			</div>
		</div>
		<div class="menber-info">
		  <div class="info-box"><p class="m-points"><?php echo $obj['user_points']; ?></p><p class="text-small">我的积分</p></div>
		  <div class="info-box"><a href="<?php echo url('user/popedom'); ?>"><p><?php if($obj['group_id'] < 3): ?><?php echo $user['group']['group_name']; else: ?><i class="iconfont user_vip">&#xe638;</i><?php echo $obj['group']['group_name']; endif; ?></p><p class="text-small"><?php if($obj['group_id'] < 3): ?>永久有效<?php else: ?><?php echo date('Y-m-d',$obj['user_end_time']); ?>到期<?php endif; ?></p></a></div>
		</div>
		<ul>
			<li><a class="flip" href="javascript:void(0)"><span class="xs1"><i class="iconfont huiyuan ver_none">&#xe661;</i>推荐有礼<i class="iconfont ico-right">&#xe623;</i></span><span class="xs2" style="display:none;"><i class="iconfont huiyuan ver_none">&#xe661;</i>推荐有礼<i class="iconfont ico-right">&#xe63a;</i></span><span class="user-time">推荐好友赚现金</span></a>
				<div class="panel" style="display:none;">
		        <?php if($GLOBALS['config']['user']['reward_status'] == 1): ?>
			            <div class="tuijian-ad">
			                <?php if($conch['theme']['ads']['user']['btn'] == 1): ?>
<a href="javascript:void(0)" target="_blank"><img src="<?php echo mac_url_img($conch['theme']['ads']['user']['pic']); ?>"></a>
<?php endif; ?>
					    </div>
				        <p class="hui">说明：推荐访问一次获得<?php echo $GLOBALS['config']['user']['invite_visit_points']; ?>积分，推荐注册一次获得<?php echo $GLOBALS['config']['user']['invite_reg_points']; ?>积分，<?php echo $GLOBALS['config']['user']['cash_ratio']; ?>积分等于1元。</p>
					<?php if($GLOBALS['config']['user']['invite_reg_points'] > 0): ?>
						<p><span class="xiang"><i class="iconfont">&#xe63a;</i>推荐注册链接</span>
							<a id="btn" class="bind-a" data-clipboard-text="<?php echo $maccms['http_type']; ?><?php echo $maccms['site_url']; ?><?php echo mac_url('user/reg'); ?>?uid=<?php echo $obj['user_id']; ?>" href="javascript:void(0)">复制注册链接</a>
						</p>
						<p><input id="url" class="member-input wt-input" value="<?php echo $maccms['http_type']; ?><?php echo $maccms['site_url']; ?><?php echo mac_url('user/reg'); ?>?uid=<?php echo $obj['user_id']; ?>" size="70">
						</p>
					<?php endif; if($GLOBALS['config']['user']['invite_visit_points'] > 0): ?>
						<p><span class="xiang"><i class="iconfont">&#xe63a;</i>推荐访问链接</span>
							<a id="btn2" class="bind-a" data-clipboard-text="<?php echo $maccms['http_type']; ?><?php echo $maccms['site_url']; ?><?php echo mac_url('user/visit'); ?>?uid=<?php echo $obj['user_id']; ?>" href="javascript:void(0)">复制访问链接</a>
						</p>
						<p><input id="url2" class="member-input wt-input" value="<?php echo $maccms['http_type']; ?><?php echo $maccms['site_url']; ?><?php echo mac_url('user/visit'); ?>?uid=<?php echo $obj['user_id']; ?>" size="70"></p>
					<?php endif; else: ?>
				    <p class="hui">抱歉，推荐有礼活动暂未开放</p>
				<?php endif; ?>
				</div>
			</li>
		</ul>
		<ul>
			<li><a href="<?php echo url('user/ajax_info'); ?>"><i class="iconfont yonghu">&#xe62b;</i>我的资料<i class="iconfont ico-right">&#xe623;</i></a></li>
			<li><a href="<?php echo url('user/info'); ?>"><i class="iconfont xiugai">&#xe65e;</i>修改资料<i class="iconfont ico-right">&#xe623;</i></a></li>
		</ul>
		<ul>
			<li><a href="<?php echo url('user/favs'); ?>"><i class="iconfont lishi">&#xe629;</i>我的收藏<i class="iconfont ico-right">&#xe623;</i></a></li>
			<li><a href="<?php echo url('user/plays'); ?>"><i class="iconfont lishi">&#xe624;</i>观看记录<i class="iconfont ico-right">&#xe623;</i></a></li>
			<li><a href="<?php echo url('user/downs'); ?>"><i class="iconfont lishi">&#xe63c;</i>下载记录<i class="iconfont ico-right">&#xe623;</i></a></li>
		</ul>
		<ul>
			<li><a href="<?php echo url('user/upgrade'); ?>"><i class="iconfont huiyuan">&#xe638;</i>升级会员<i class="iconfont ico-right">&#xe623;</i></a></li>
			<li><a href="<?php echo url('user/buy'); ?>"><i class="iconfont xiazai">&#xe65c;</i>充值中心<i class="iconfont ico-right">&#xe623;</i></a></li>
			<li><a href="<?php echo url('user/orders'); ?>"><i class="iconfont xiazai">&#xe660;</i>充值记录<i class="iconfont ico-right">&#xe623;</i></a></li>
			<li><a href="<?php echo url('user/cash'); ?>"><i class="iconfont xiazai">&#xe65f;</i>我要提现<i class="iconfont ico-right">&#xe623;</i></a></li>
		</ul>
		<ul>
            <li><a href="<?php echo url('user/plog'); ?>"><i class="iconfont congzhi">&#xe662;</i>积分记录<i class="iconfont ico-right">&#xe623;</i></a></li>
			<li><a href="<?php echo url('user/reward'); ?>"><i class="iconfont congzhi">&#xe65d;</i>推荐记录<i class="iconfont ico-right">&#xe623;</i></a></li>
		</ul>
		<ul class="logout-ul">
			<li class="logout-item" ><a class="logout-link" href="<?php echo url('user/logout'); ?>" >退出账号</a></li>
		</ul>
	</div>
	<div id="right" class="dr-no">
		<div class="m-nav">
			<a href="javascript:MAC.GoBack()" class="btn-left"><i class="iconfont ico-right">&#xe625;</i></a>
			<a href="<?php echo url('user/info'); ?>" class="btn-right">修改</a>
			<span class="mb-title">基本资料</span>
	    </div>
	    <div class="co-right co-right-bg">
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
					<p><span class="xiang">用户名</span><?php echo $obj['user_name']; ?></p>
					<p><span class="xiang">所属会员组</span><?php if($obj['group_id'] < 3): ?><?php echo $user['group']['group_name']; else: ?><i class="iconfont user_vip">&#xe638;</i><?php echo $obj['group']['group_name']; endif; ?></p>
					<p><span class="xiang">账户积分</span><?php echo $obj['user_points']; ?></p>
					<p><span class="xiang">会员期限</span><?php if($obj['group_id'] < 3): ?>永久有效<?php else: ?><?php echo mac_day($obj['user_end_time']); endif; ?></p>
					<p><span class="xiang">QQ号码</span><?php echo mac_default($obj['user_qq'],'未填写'); ?></p>
					<p><span class="xiang">Email地址</span><?php echo mac_default($obj['user_email'],'未填写'); ?></p>
					<p><span class="xiang">注册时间</span><?php echo mac_day($obj['user_reg_time']); ?></p>
					<p><span class="xiang">上次登录</span><?php echo mac_day($obj['user_last_login_time'],color); ?></p>
					<p><span class="xiang">登录次数</span><?php echo $obj['user_login_num']; ?></p>
					<p><span class="xiang">登陆IP</span><?php echo long2ip($obj['user_login_ip']); ?></p>
					<p><span class="xiang">登陆时间</span><?php echo mac_day($obj['user_login_time']); ?></p>
				</div>
			</div>
		</div>
	 </div>
	 </div>
</div>
<div id="show" style="display: none;">
    <div class="co-cg">
       <p>耶～～复制成功</p>
    </div>
</div>
<script>
	$(".face").imageUpload({
		formAction: "<?php echo url('user/portrait'); ?>",
		inputFileName:'file',
		browseButtonValue: '<i class="iconfont xiazai">&#xe65e;</i>',
		browseButtonClass:'btn btn-default btn-xs face-upload',
		automaticUpload: true,
		hideDeleteButton: true,
		hover:true
	})
	$(".face").on("imageUpload.uploadFailed", function (ev, err) {
		alert(err);
	});
</script>
<!-- // sign-content end -->
<div class="footer <?php if($conch['theme']['fnav']['btn'] == 1): ?>foot_nav<?php endif; ?> clearfix">
	<div class="layout">
		<div class="copyright">
			<p>&copy; <?php echo date('Y'); ?> <a class="color" href="//<?php echo $maccms['site_url']; ?>"><?php echo $maccms['site_url']; ?></a>  All Rights Reserved.</p>
		</div>
	</div>
	<?php if($conch['theme']['fnav']['btn'] == 1): ?>
<div class="foot_mnav hidden_mb">
	<ul class="foot_rows">
	    <?php if(strpos($conch['theme']['fnav']['ym'],'h') !==false): ?>
		<li class="foot_text">
			<a <?php if($maccms['aid'] == 1): ?>class="active" <?php endif; ?>href="<?php echo $maccms['path']; ?>">
				<?php if($maccms['aid'] == 1): ?><i class="iconfont">&#xe678;</i><?php else: ?><i class="iconfont">&#xe634;</i><?php endif; ?>
				<span class="foot_font">首页</span>
			</a>
		</li>
		<?php endif; $__TAG__ = '{"num":"5","order":"asc","by":"sort","ids":"'.$conch['theme']['fnav']['id'].'","id":"vo1","key":"key1"}';$__LIST__ = model("Type")->listCacheData($__TAG__); if(is_array($__LIST__['list']) || $__LIST__['list'] instanceof \think\Collection || $__LIST__['list'] instanceof \think\Paginator): $key1 = 0; $__LIST__ = $__LIST__['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($key1 % 2 );++$key1;?>
		<li class="foot_text">
			<a <?php if(($vo1['type_id'] == $GLOBALS['type_id'] || $vo1['type_id'] == $GLOBALS['type_pid'])): ?>class="active"<?php endif; ?> href="<?php echo mac_url_type($vo1); ?>">	
				<?php if(($vo1['type_id'] == $GLOBALS['type_id'] || $vo1['type_id'] == $GLOBALS['type_pid'])): if(stristr($vo1['type_name'],'纪录片')==true||stristr($vo1['parent']['type_name'],'纪录片')==true): ?><i class="iconfont">&#xe66f;</i><?php elseif(stristr($vo1['type_name'],'福利')==true||stristr($vo1['parent']['type_name'],'福利')==true): ?><i class="iconfont">&#xe677;</i><?php else: ?><i class="iconfont"><?php switch($vo1['type_id']): case "1": ?>&#xe671;<?php break; case "2": ?>&#xe672;<?php break; case "3": ?>&#xe676;<?php break; case "4": ?>&#xe66c;<?php break; case "5": ?>&#xe67d;<?php break; case $conch['theme']['type']['zb']: ?>&#xe66b;<?php break; default: ?>&#xe675;<?php endswitch; ?></i><?php endif; else: if(stristr($vo1['type_name'],'纪录片')==true||stristr($vo1['parent']['type_name'],'纪录片')==true): ?><i class="iconfont">&#xe651;</i><?php elseif(stristr($vo1['type_name'],'福利')==true||stristr($vo1['parent']['type_name'],'福利')==true): ?><i class="iconfont">&#xe655;</i><?php else: ?><i class="iconfont"><?php switch($vo1['type_id']): case "1": ?>&#xe64a;<?php break; case "2": ?>&#xe649;<?php break; case "3": ?>&#xe64b;<?php break; case "4": ?>&#xe648;<?php break; case "5": ?>&#xe630;<?php break; case $conch['theme']['type']['zb']: ?>&#xe650;<?php break; default: ?>&#xe647;<?php endswitch; ?></i><?php endif; endif; ?>
				<span class="foot_font"><?php echo $vo1['type_name']; ?></span>
			</a>
		</li>
		<?php endforeach; endif; else: echo "" ;endif; if($conch['theme']['fnav']['zdybtn1'] == 1): ?>
		<li class="foot_text">
			<a href="<?php echo $conch['theme']['fnav']['zdylink1']; ?>" target="_blank">		
				<i class="iconfont">&#xe666;</i>
				<span class="foot_font"><?php echo $conch['theme']['fnav']['zdyname1']; ?></span>
			</a>
		</li>
		<?php endif; if($conch['theme']['fnav']['zdybtn2'] == 1): ?>
		<li class="foot_text">
			<a href="<?php echo $conch['theme']['fnav']['zdylink2']; ?>" target="_blank">		
				<i class="iconfont">&#xe668;</i>
				<span class="foot_font"><?php echo $conch['theme']['fnav']['zdyname2']; ?></span>
			</a>
		</li>
		<?php endif; if($conch['theme']['topic']['btn'] == 1): if(strpos($conch['theme']['fnav']['ym'],'a') !==false): ?>
		<li class="foot_text">
			<a <?php if($maccms['mid'] == 3): ?>class="active" <?php endif; ?>href="<?php echo mac_url_topic_index(); ?>">		
				<?php if($maccms['mid'] == 3): ?><i class="iconfont">&#xe67c;</i><?php else: ?><i class="iconfont">&#xe64c;</i><?php endif; ?>
				<span class="foot_font"><?php echo mac_default($conch['theme']['topic']['title'],'专题'); ?></span>
			</a>
		</li>
		<?php endif; endif; if($GLOBALS['config']['gbook']['status'] == 1): if(strpos($conch['theme']['fnav']['ym'],'b') !==false): ?>
		<li class="foot_text">
			<a <?php if($maccms['aid'] == 4): ?>class="active" <?php endif; ?>href="<?php echo mac_url('gbook/index'); ?>">		
				<?php if($maccms['aid'] == 4): ?><i class="iconfont">&#xe66d;</i><?php else: ?><i class="iconfont">&#xe632;</i><?php endif; ?>
				<span class="foot_font"><?php echo mac_default($conch['theme']['gbook']['title'],'留言'); ?></span>
			</a>
		</li>
		<?php endif; endif; if($conch['theme']['map']['btn'] == 1): if(strpos($conch['theme']['fnav']['ym'],'c') !==false): ?>
		<li class="foot_text">
			<a <?php if($maccms['aid'] == 2): ?>class="active" <?php endif; ?>href="<?php echo mac_url('map/index'); ?>">		
				<?php if($maccms['aid'] == 2): ?><i class="iconfont">&#xe66e;</i><?php else: ?><i class="iconfont">&#xe652;</i><?php endif; ?>
				<span class="foot_font"><?php echo mac_default($conch['theme']['map']['title'],'最新'); ?></span>
			</a>
		</li>
		<?php endif; endif; if($conch['theme']['rank']['btn'] == 1): if(strpos($conch['theme']['fnav']['ym'],'d') !==false): ?>
		<li class="foot_text">
			<a <?php if($maccms['aid'] == 7): ?>class="active" <?php endif; ?>href="<?php echo mac_url('label/rank'); ?>">		
				<i class="iconfont">&#xe618;</i>
				<span class="foot_font"><?php echo mac_default($conch['theme']['rank']['title'],'排行榜'); ?></span>
			</a>
		</li>
		<?php endif; endif; if($conch['theme']['actor']['btn'] == 1): if(strpos($conch['theme']['fnav']['ym'],'e') !==false): ?>
		<li class="foot_text">
			<a <?php if($maccms['mid'] == 8): ?>class="active" <?php endif; ?>href="<?php echo mac_url('actor/index'); ?>">		
				<?php if($maccms['mid'] == 8): ?><i class="iconfont">&#xe670;</i><?php else: ?><i class="iconfont">&#xe629;</i><?php endif; ?>
				<span class="foot_font"><?php echo mac_default($conch['theme']['actor']['title'],'明星'); ?></span>
			</a>
		</li>
		<?php endif; endif; if($conch['theme']['role']['btn'] == 1): if(strpos($conch['theme']['fnav']['ym'],'f') !==false): ?>
		<li class="foot_text">
			<a <?php if($maccms['mid'] == 9): ?>class="active" <?php endif; ?>href="<?php echo mac_url('role/index'); ?>">		
				<?php if($maccms['mid'] == 9): ?><i class="iconfont">&#xe674;</i><?php else: ?><i class="iconfont">&#xe654;</i><?php endif; ?>
				<span class="foot_font"><?php echo mac_default($conch['theme']['role']['title'],'角色'); ?></span>
			</a>
		</li>
		<?php endif; endif; if($conch['theme']['plot']['btn'] == 1): if(strpos($conch['theme']['fnav']['ym'],'h') !==false): ?>
		<li class="foot_text">
			<a <?php if($maccms['mid'] == 10): ?>class="active" <?php endif; ?>href="<?php echo mac_url('plot/index'); ?>">		
				<?php if($maccms['mid'] == 10): ?><i class="iconfont">&#xe67d;</i><?php else: ?><i class="iconfont">&#xe630;</i><?php endif; ?>
				<span class="foot_font"><?php echo mac_default($conch['theme']['plot']['title'],'剧情'); ?></span>
			</a>
		</li>
		<?php endif; endif; if($GLOBALS['config']['user']['status'] == 1): if(strpos($conch['theme']['fnav']['ym'],'g') !==false): ?>
		<li class="foot_text">
			<a <?php if($maccms['aid'] == 6): ?>class="active"<?php endif; ?> href="<?php if($user['user_id']): ?><?php echo mac_url('user/index'); else: ?><?php echo mac_url('user/login'); endif; ?>">	
				<?php if($maccms['aid'] == 6): ?><i class="iconfont">&#xe67a;</i><?php else: ?><i class="iconfont">&#xe62b;</i><?php endif; ?>
				<span class="foot_font"><?php echo mac_default($conch['theme']['user']['title'],'会员'); ?></span>
			</a>
		</li>
		<?php endif; endif; ?>
	</ul>
</div>
<?php endif; ?>
</div>
<!-- // footer end -->
<script src="<?php echo $maccms['path_tpl']; ?>asset/js/stem/clipboard.min.js"></script>
<script src="<?php echo $maccms['path_tpl']; ?>asset/js/stem/jquery.lazyload.min.js"></script>
<script type="text/javascript">
    $(".flip").click(function(){
		$(".panel").slideToggle("slow");
		$(".xs1").toggle();
		$(".xs2").toggle();
    });
</script>
<script>
	var btn=document.getElementById('btn');
	var clipboard=new Clipboard(btn);
	clipboard.on('success', function(e){
		$('#show').slideDown().delay(1500).slideUp(300);
	});
	clipboard.on('error', function(e){
		$('#show').slideDown().delay(1500).slideUp(300);
	});
	var btn=document.getElementById('btn2');
	var clipboard=new Clipboard(btn2);
	clipboard.on('success', function(e){
		$('#show').slideDown().delay(1500).slideUp(300);
	});
	clipboard.on('error', function(e){
		$('#show').slideDown().delay(1500).slideUp(300);
	});
</script>
<script type="text/javascript">
	$(".lazyload").lazyload({
	effect: "fadeIn",
	threshold: 200,
	failurelimit: 15,
	skip_invisible: !1
	})
</script>
</body>
</html>