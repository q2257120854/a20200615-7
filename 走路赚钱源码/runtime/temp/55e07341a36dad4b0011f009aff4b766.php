<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:74:"D:\wwwroot\yoopay.top\public/../application/admincmsby\view\users\set.html";i:1562144059;s:75:"D:\wwwroot\yoopay.top\public/../application/admincmsby\view\index\base.html";i:1557824309;s:78:"D:\wwwroot\yoopay.top\public/../application/admincmsby\view\public\header.html";i:1557838008;s:76:"D:\wwwroot\yoopay.top\public/../application/admincmsby\view\public\left.html";i:1560258805;s:78:"D:\wwwroot\yoopay.top\public/../application/admincmsby\view\public\footer.html";i:1524125862;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>后台管理系统</title>
<meta name="author" content="广州是财富天下信息科技有限公司" />
<link rel="stylesheet" type="text/css" href="__ADMIN_CSS__/style.css">

<!--[if lt IE 9]>
<script src="__ADMIN_JS__/html5.js"></script>
<![endif]-->
<script src="__ADMIN_JS__/jquery.js"></script>
<script src="__ADMIN_JS__/jquery.mCustomScrollbar.concat.min.js"></script>


	<style>
		.textbox{
			text-align:center;
		}
		.errorTips {
			color: #929292;
		}
		.item_name{
			/*font-size:14px;*/
			font-weight:600;
		}
	</style>

<style>
.rt_content{
	width:auto;
}
.table{
	max-width:100%;
}
</style>
<script>

	(function($){
		$(window).load(function(){
			
			$("a[rel='load-content']").click(function(e){
				e.preventDefault();
				var url=$(this).attr("href");
				$.get(url,function(data){
					$(".content .mCSB_container").append(data); //load new content inside .mCSB_container
					//scroll-to appended content 
					$(".content").mCustomScrollbar("scrollTo","h2:last");
				});
			});
			
			$(".content").delegate("a[href='top']","click",function(e){
				e.preventDefault();
				$(".content").mCustomScrollbar("scrollTo",$(this).attr("href"));
			});
			
		});
	})(jQuery);
</script>
<style>
.edui-default .edui-editor,.edui-default .edui-editor-iframeholder{
	position: static !important;
}
</style>
</head>

<body>

<!--header-->
<header>
 <h1><img src="__ADMIN_IMG__/admin_logo.png"/></h1>
 <ul class="rt_nav">
  <li><a href="/" target="_blank" class="website_icon">站点首页</a></li>
  <li><a href="#" class="clear_icon" id="clear">清除缓存</a></li>
  <li><a href="#" class="admin_icon"><?php echo $account; ?></a></li>
  <li><a href="<?php echo url('adminbrother/edit'); ?>?id=<?php echo $adminid; ?>" class="set_icon">账号设置</a></li>
  <li><a href="<?php echo url('index/quit'); ?>" class="quit_icon">安全退出</a></li>
 </ul>
</header>
<link rel="stylesheet" type="text/css" href="__CSS__/myalert.css" />
<script type="text/javascript" src="__JS__/jquery.min.js"></script>
<script src="__JS__/myAlert.js"></script>
<style>
.myModa .myAlertBox h6{
	background: #302931;
	color:#fff;
	font-weight:600;
}
.myModa .myAlertBox .btn{
	color:#fff;
	background: #13a174;
	border: 1px #13a174 solid;
}
.paging{
	float:right;
}
.paging a{
	margin-left:2px;
}
.paging a.current{
	background: #ff49ff;
	border: 1px #ff49ff solid;
	font-weight: 600;
}
.paging_left{
    margin: 8px 0;
    overflow: hidden;
	float:left;
	margin-top: 30px;
}
.paging_left a {
    background: #302931;
    border: 1px #139667 solid;
    color: white;
    padding: 5px 8px;
    display: inline-block;
    cursor: pointer;
	margin-left: 2px;
}
.texlong{
	position:absolute;
}
.textarea{
	margin-left:120px;
}
.textbox_long{
	width:640px;
}
.geshi{
	text-align: right;
	margin-left:120px;
	padding-top:10px;
	display: inline-block;
	color:#8c8b8b;
}
.uploadImg img{
	max-width:200px;
}
</style>
<script>
$(document).ready(function() {
  //测试提交，对接程序删除即可
	$('#clear').click(function(event){
		$.ajax({
			url:"<?php echo url('cmmcom/clearcache'); ?>",
			dataType:"json",
			type:'POST',
			cache:false,
			data:{clear:'ok'},
			success: function(data) {
				console.log(data.s);
				if (data.s=='ok') {
					myAlert('清楚缓存成功');
					setTimeout(function(){
						//页面刷新  
						window.location.reload();
					},1000);
				}else {
					myAlert(data.s);
				}
			}
		});
	});  
	
});
</script>	
<!-- 导航 -->
<!--aside nav-->
 <style>
	.nav_a{
		font-size:23px;
	}

 </style>
<script>
$(document).ready(function() {
	//隐藏
	//$("aside li dd").hide();
	$("aside li dt a").click(function() {
		var htm = $(this).html();
		if(htm=="+"){
			$(this).parent().nextAll().css("display","block");
			$(this).html("▬&nbsp;");
			$(this).removeClass("nav_a");
		}else{
			 $(this).parent().nextAll().css("display","none");
			 $(this).html("+");
			 $(this).addClass("nav_a");
		}
		console.log(htm);
	});
	$("aside li dd a").each(function() {
		var class_ = $(this).attr("class");
		//console.log(class_);
		if(class_=="active"){
			$(this).parent().parent().find("dt a").html("▬&nbsp;");
			$(this).parent().parent().find("dt a").removeClass("nav_a");
			$(this).parent().parent().find("dd").css("display","block");
		}
		
		
	});	
});
</script>
<aside class="lt_aside_nav content mCustomScrollbar">
 <h2><a href="<?php echo url('index/main'); ?>">起始页</a></h2>
 <ul>
 <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $key=>$v): ?>
  <li>
   <dl>
    <dt><a href="#" class="nav_a" style="color:#302931;">+</a>&nbsp;<?php echo $v['title']; ?></dt>
    <!--当前链接则添加class:active-->
	<?php if(is_array($v['list']) || $v['list'] instanceof \think\Collection || $v['list'] instanceof \think\Paginator): if( count($v['list'])==0 ) : echo "" ;else: foreach($v['list'] as $key=>$vo): ?>
    <dd style="display:none;"><a href="<?php echo $vo['url']; ?>" class="<?php if($vo['op'] == 'admin'): ?><?php echo $admin_l; endif; if($vo['op'] == 'group'): ?><?php echo $group_l; endif; if($vo['op'] == 'power'): ?><?php echo $power_l; endif; if($vo['op'] == 'operatelog'): ?><?php echo $operate_l; endif; if($vo['op'] == 'loginlog'): ?><?php echo $loginlog_l; endif; if($vo['op'] == 'web'): ?><?php echo $web_l; endif; if($vo['op'] == 'tradelog'): ?><?php echo $trade_l; endif; if($vo['op'] == 'backup'): ?><?php echo $backup_l; endif; if($vo['op'] == 'restore'): ?><?php echo $restore_l; endif; if($vo['op'] == 'redeemcode'): ?><?php echo $code_l; endif; if($vo['op'] == 'adlist'): ?><?php echo $ad_l; endif; if($vo['op'] == 'makecode'): ?><?php echo $makec_l; endif; if($vo['op'] == 'sellorder'): ?><?php echo $sello_l; endif; if($vo['op'] == 'market'): ?><?php echo $market_l; endif; if($vo['op'] == 'contact'): ?><?php echo $contact_l; endif; if($vo['op'] == 'buyorder'): ?><?php echo $buyo_l; endif; if($vo['op'] == 'message'): ?><?php echo $msg_l; endif; if($vo['op'] == 'partner'): ?><?php echo $partner_l; endif; if($vo['op'] == 'notice'): ?><?php echo $notice_l; endif; if($vo['op'] == 'recruit'): ?><?php echo $recruit_l; endif; if($vo['op'] == 'userlist'): ?><?php echo $user_l; endif; if($vo['op'] == 'recharge'): ?><?php echo $recharge_l; endif; if($vo['op'] == 'recharge_log'): ?><?php echo $rec_log_l; endif; if($vo['op'] == 'userset'): ?><?php echo $set_l; endif; if($vo['op'] == 'ore'): ?><?php echo $ore_l; endif; if($vo['op'] == 'oreadd'): ?><?php echo $oreadd_l; endif; if($vo['op'] == 'oreset'): ?><?php echo $oreset_l; endif; if($vo['op'] == 'bonuslog'): ?><?php echo $bonus_l; endif; if($vo['op'] == 'ore_o'): ?><?php echo $oreo_l; endif; if($vo['op'] == 'ore_p'): ?><?php echo $orep_l; endif; if($vo['op'] == 'gift'): ?><?php echo $gift_l; endif; if($vo['op'] == 'release'): ?><?php echo $release_l; endif; ?>">&nbsp;&nbsp;<?php echo $vo['name']; ?></a></dd>
	<?php endforeach; endif; else: echo "" ;endif; ?>
   </dl>
  </li>
  <?php endforeach; endif; else: echo "" ;endif; ?>
  <li>
   <p class="btm_infor">© tmc.cn 版权所有</p>
  </li>
 </ul>
</aside>




<section class="rt_wrap content mCustomScrollbar">
 <div class="rt_content">
      <div class="page_title">
       <h2 class="fl">会员设置</h2>
      </div>
     <section>
      <ul class="ulColumn2">
	<!--   <form enctype="multipart/form-data" id="uploadForm"> -->
       <li>
        <span class="item_name" style="width:120px;">注册送：</span>
        <!--<input type="text" class="textbox textbox_195"  name="SET_REG_GIVE" value="<?php echo $result['SET_REG_GIVE']; ?>" placeholder="微型钻箱数量..."/>&nbsp;个 &nbsp; -->送POW额度<input type="text" class="textbox textbox_195"  name="SET_usable_coin" value="<?php echo $result['SET_usable_coin']; ?>" placeholder="POW额度..."/>&nbsp;个&nbsp; 送乐豆<input type="text" class="textbox textbox_195"  name="SET_usable_money" value="<?php echo $result['SET_usable_money']; ?>" placeholder="乐豆..."/>&nbsp;个
       </li> 
       <li>
        <span class="item_name" style="width:120px;">买入数量限制：</span>
        买入数量为<input type="text" class="textbox textbox_195"  name="SET_buy_limit" value="<?php echo $result['SET_buy_limit']; ?>" placeholder="倍数..."/>&nbsp;的倍数
       </li>
       <li>
        <span class="item_name" style="width:120px;">同时买入限制：</span>
        最多同时买入<input type="text" class="textbox textbox_195"  name="SET_buy_nums" value="<?php echo $result['SET_buy_nums']; ?>" placeholder="数量..."/>&nbsp;张订单
       </li>
       <li>
        <span class="item_name" style="width:120px;">乐豆的兑换率：</span>
        1个乐豆等于<input type="text" class="textbox textbox_195"  name="SET_coin_rate" value="<?php echo $result['SET_coin_rate']; ?>" placeholder="数量..."/>&nbsp;个POW
       </li>
	   
       <li>
        <span class="item_name" style="width:120px;">每天释放乐豆：</span>
        <input type="text" class="textbox textbox_195"  name="SET_release" value="<?php echo $result['SET_release']; ?>" placeholder="释放乐豆..."/>&nbsp;%<span class="errorTips">列如：千分之一即&nbsp;0.1%</span>
       </li>
	   
       <li>
        <span class="item_name" style="width:120px;">卖出乐豆手续费：</span>
        <input type="text" class="textbox textbox_195"  name="SET_poundage" value="<?php echo $result['SET_poundage']; ?>" placeholder="手续费..."/>&nbsp;%
       </li>
       <li>
        <span class="item_name" style="width:120px;">POW额度：</span>
        <input type="text" class="textbox textbox_195"  name="SET_usable" value="<?php echo $result['SET_usable']; ?>" placeholder="POW额度..."/>&nbsp;%
       </li>
	
       <li>
        <span class="item_name" style="width:120px;">冻结账号：</span>
        确认付款时限&nbsp;<input type="text" class="textbox textbox_195" name="SET_paytime_end" value="<?php echo $result['SET_paytime_end']; ?>" placeholder="时限..."/>&nbsp;小时&nbsp;&nbsp;&nbsp;确认收款时限&nbsp;
		<input type="text" class="textbox textbox_195" name="SET_yestime_end" value="<?php echo $result['SET_yestime_end']; ?>" placeholder="时限..."/>&nbsp;小时
		&nbsp;
       </li>
	   
       <li hidden>
        <span class="item_name" style="width:120px;">每用户钻箱数量：</span>
        微型钻箱最多&nbsp;<input type="text" class="textbox textbox_195" name="SET_kjnum_1" value="<?php echo $result['SET_kjnum_1']; ?>" placeholder="微型钻箱数..."/>&nbsp;台&nbsp;小型钻箱最多&nbsp;
		<input type="text" class="textbox textbox_195" name="SET_kjnum_2" value="<?php echo $result['SET_kjnum_2']; ?>" placeholder="小型钻箱数..."/>&nbsp;台
		&nbsp;
       </li>
       <li>
        <span class="item_name" style="width:120px;">&nbsp;</span>
        中型钻箱最多&nbsp;
		<input type="text" class="textbox textbox_195" name="SET_kjnum_3" value="<?php echo $result['SET_kjnum_3']; ?>" placeholder="中型钻箱人数..."/>&nbsp;台
		&nbsp;大型钻箱最多&nbsp;<input type="text" class="textbox textbox_195" name="SET_kjnum_4" value="<?php echo $result['SET_kjnum_4']; ?>" placeholder="大型钻箱数..."/>&nbsp;台
       </li>
	   
       <li>
        <span class="item_name" style="width:120px;">会员解封费用：</span>
        会员等级&nbsp;<input type="text" class="textbox textbox_195" name="SET_unsealing" value="<?php echo $result['SET_unsealing']; ?>" placeholder="会员等级..."/>&nbsp;&nbsp;会员费率&nbsp;
		<input type="text" class="textbox textbox_195" name="SET_unsealing_money" value="<?php echo $result['SET_unsealing_money']; ?>" placeholder="扣除POW额度..."/>&nbsp;POW额度
		&nbsp;
       </li>
	   
	   
       <li hidden>
        <span class="item_name" style="width:120px;">直推奖：</span>
        直推&nbsp;<input type="text" class="textbox textbox_195" name="SET_groom_1" value="<?php echo $result['SET_groom_1']; ?>" placeholder="直推人数..."/>&nbsp;人送微型钻箱一台；&nbsp;直推&nbsp;
		<input type="text" class="textbox textbox_195" name="SET_groom_2" value="<?php echo $result['SET_groom_2']; ?>" placeholder="直推人数..."/>&nbsp;人送小型钻箱一台
		；&nbsp;
       </li>
       <li>
        <span class="item_name" style="width:120px;">&nbsp;</span>
        直推&nbsp;
		<input type="text" class="textbox textbox_195" name="SET_groom_3" value="<?php echo $result['SET_groom_3']; ?>" placeholder="直推人数..."/>&nbsp;人送中型型钻箱一台
		；&nbsp;直推&nbsp;<input type="text" class="textbox textbox_195" name="SET_groom_4" value="<?php echo $result['SET_groom_4']; ?>" placeholder="直推人数..."/>&nbsp;人送大型型钻箱一台
       </li>
	   
       <li hidden>
        <span class="item_name" style="width:120px;">打捞乐豆收益：</span>
        总金额小于&nbsp;<input type="text" class="textbox textbox_195" name="SET_FRY_AMOUNT" value="<?php echo $result['SET_FRY_AMOUNT']; ?>" placeholder="打捞乐豆收益..."/>&nbsp;￥&nbsp;时，收益等于
		<input type="text" class="textbox textbox_195" name="SET_FRY_PROFIT" value="<?php echo $result['SET_FRY_PROFIT']; ?>" placeholder="打捞乐豆收益..."/>&nbsp;￥
        <span class="errorTips">总金额小于100元时</span>
       </li>
	      
	   <li hidden>
        <span class="item_name" style="width:150px;">打捞乐豆收益百分比：&nbsp;</span>
		<input type="text" class="textbox textbox_195" name="SET_FRY_PER" value="<?php echo $result['SET_FRY_PER']; ?>" placeholder="打捞鱼苗收益..."/>&nbsp;%
        <span class="errorTips">列如：总金额大于100元时，打捞乐豆收益百分比为总金额的&nbsp;2%</span>
       </li>
	   
       <li >
        <span class="item_name" style="width:120px;">签到最低收益：</span>
        总金额小于&nbsp;<input type="text" class="textbox textbox_195" name="SET_SING_AMOUNT" value="<?php echo $result['SET_SING_AMOUNT']; ?>" placeholder="签到收益..."/>&nbsp;￥&nbsp;时，收益等于
		<input type="text" class="textbox textbox_195" name="SET_SING_PROFIT" value="<?php echo $result['SET_SING_PROFIT']; ?>" placeholder="签到收益..."/>&nbsp;￥
        <span class="errorTips">总金额小于100元时</span>
       </li>

       <li >
        <span class="item_name" style="width:120px;">签到收益百分比：&nbsp;</span>
		<input type="text" class="textbox textbox_195" name="SET_SING_PER" value="<?php echo $result['SET_SING_PER']; ?>" placeholder="签到收益..."/>&nbsp;%
        <span class="errorTips">列如：总金额大于100元时，签到收益百分比为总金额的&nbsp;2%</span>
       </li>

       <li hidden>
        <span class="item_name" style="width:120px;">加速卡收益+：</span>
        <input type="text" class="textbox textbox_195"  name="SET_SING_CARD" value="<?php echo $result['SET_SING_CARD']; ?>" placeholder="加速卡收益+..."/>&nbsp;%
		<span class="errorTips">列如：普通日签到收益为2%，使用加速卡，收益累加到日4%</span>
       </li>  

       <li hidden>
        <span class="item_name" style="width:120px;">加速卡期限：</span>
        <input type="text" class="textbox textbox_195"  name="SET_CARD_TERM" value="<?php echo $result['SET_CARD_TERM']; ?>" placeholder="使用期限..."/>&nbsp;天
		<span class="errorTips">列如：加速卡使用期限，两张以上加速卡可同时使用，即累加天数3+3+....</span>
       </li>  	   
	   
       <li >
        <span class="item_name" style="width:120px;">日转账交易设置：</span>
        总金额的&nbsp;<input type="text" class="textbox textbox_195"  name="SET_DAY_PER" value="<?php echo $result['SET_DAY_PER']; ?>" placeholder="日转账占比..."/>&nbsp;%
		<span class="errorTips">占总金额百分比，含卖出和转账总额度</span>
       </li>  
	   
       <li>
        <span class="item_name" style="width:120px;">兑换码：</span>
        总金额&nbsp;<input type="text" class="textbox textbox_195" name="SET_CODE_AMOUNT" value="<?php echo $result['SET_CODE_AMOUNT']; ?>" placeholder="总金额条件..."/>&nbsp;￥&nbsp;以上，或者直推团队&nbsp;
		<input type="text" class="textbox textbox_195" name="SET_CODE_TEAM" value="<?php echo $result['SET_CODE_TEAM']; ?>" placeholder="团队人数..."/>&nbsp;人以上完成充值，
		赠送&nbsp;<input type="text" class="textbox textbox_195" name="SET_CODE_NUM" value="<?php echo $result['SET_CODE_NUM']; ?>" placeholder="兑换码数量..."/>&nbsp;个兑换码（即加速卡）
       </li>
       <li>
        <span class="item_name" style="width:120px;">&nbsp;</span>
		 <span class="errorTips">		
			列如：钱包总余额达到1000个，或者直推下级有10个人充值了，就送个兑换码 
		 </span>
       </li>
	   
       <li>
        <span class="item_name" style="width:120px;">市场乐豆单价：</span>
        <input type="text" class="textbox textbox_195"  name="SET_GOODS_PRICE" value="<?php echo $result['SET_GOODS_PRICE']; ?>" placeholder="鱼苗单价..."/>-
		<input type="text" class="textbox textbox_195"  name="SET_GOODS_PRICE" value="<?php echo $result['SET_GOODS_PRICE']; ?>" placeholder="鱼苗单价..."/>&nbsp;￥/币
		<span class="errorTips">市场乐豆单价必须大于0</span>
       </li> 
	   
       <li>
        <span class="item_name" style="width:120px;">最低买入数量：</span>
        <input type="text" class="textbox textbox_195"  name="SET_MIN_BUY" value="<?php echo $result['SET_MIN_BUY']; ?>" placeholder="最低买入..."/>&nbsp;个乐豆
		<span class="errorTips">如：100起买入</span>
       </li> 
       <li>
        <span class="item_name" style="width:120px;">最低卖出数量：</span>
        <input type="text" class="textbox textbox_195"  name="SET_MIN_SELL" value="<?php echo $result['SET_MIN_SELL']; ?>" placeholder="最低卖出..."/>&nbsp;个乐豆
		<span class="errorTips">如：100起卖出</span>
       </li> 
	   
       <li>
        <span class="item_name" style="width:120px;">最高买入数量：</span>
        <input type="text" class="textbox textbox_195"  name="SET_MAX_BUY" value="<?php echo $result['SET_MAX_BUY']; ?>" placeholder="最高买入..."/>&nbsp;个乐豆
		<span class="errorTips">如：1000封顶</span>
       </li> 
       <li>
        <span class="item_name" style="width:120px;">最高卖出数量：</span>
        <input type="text" class="textbox textbox_195"  name="SET_MAX_SELL" value="<?php echo $result['SET_MAX_SELL']; ?>" placeholder="最高卖出..."/>&nbsp;个乐豆
		<span class="errorTips">如：1000封顶</span>
       </li> 
	   <li>
        <span class="item_name" style="width:120px;">当天出售上限：</span>
        <input type="text" class="textbox textbox_195"  name="SET_USERSELL_NUM" value="<?php echo $result['SET_USERSELL_NUM']; ?>" placeholder="最高卖出..."/>&nbsp;次
		<span class="errorTips">如：1次</span>
       </li> 

       <li>
        <span class="item_name" style="width:120px;">钻箱市场设置：</span>
        <label class="single_selection"><input type="radio" name="SET_MARKET_CLOSE" value="1" <?php if($result['SET_MARKET_CLOSE'] == '1'): ?>checked<?php endif; ?> />开启</label>
        <label class="single_selection"><input type="radio" name="SET_MARKET_CLOSE" value="0" <?php if($result['SET_MARKET_CLOSE'] == '0'): ?>checked<?php endif; ?> />关闭</label>
       </li>

       <li hidden>
        <span class="item_name" style="width:120px;">团队奖：</span>
        <!--充值&nbsp;<input type="text" class="textbox textbox_195" name="SET_PAY_AMOUNT" value="" placeholder="充值金额..."/>&nbsp;￥&nbsp;时，-->领导奖励
		<input type="text" class="textbox textbox_195" name="SET_REWARD_PER" value="<?php echo $result['SET_REWARD_PER']; ?>" placeholder="比列..."/>&nbsp;%
        <span class="errorTips">如：15,10,5 ，请用英文逗号隔开</span>
       </li>
	   
       <li>
        <span class="item_name" style="width:120px;">团队奖：</span>
        &nbsp;<input type="text" class="textbox textbox_195" name="SET_user_Grade_1" value="<?php echo $result['SET_user_Grade_1']; ?>" placeholder="会员等级..."/>&nbsp;级会员，领导奖励
		<input type="text" class="textbox textbox_195" name="SET_user_reward_1" value="<?php echo $result['SET_user_reward_1']; ?>" placeholder="比列..."/>&nbsp;%
        <span class="errorTips">如：15,10,5 ，请用英文逗号隔开</span>
       </li>
       <li>
        <span class="item_name" style="width:120px;">&nbsp;</span>
        &nbsp;<input type="text" class="textbox textbox_195" name="SET_user_Grade_2" value="<?php echo $result['SET_user_Grade_2']; ?>" placeholder="会员等级..."/>&nbsp;级会员，领导奖励
		<input type="text" class="textbox textbox_195" name="SET_user_reward_2" value="<?php echo $result['SET_user_reward_2']; ?>" placeholder="比列..."/>&nbsp;%
        <span class="errorTips">如：15,10,5 ，请用英文逗号隔开</span>
       </li>
       <li>
        <span class="item_name" style="width:120px;">&nbsp;</span>
        &nbsp;<input type="text" class="textbox textbox_195" name="SET_user_Grade_3" value="<?php echo $result['SET_user_Grade_3']; ?>" placeholder="会员等级..."/>&nbsp;级会员，领导奖励
		<input type="text" class="textbox textbox_195" name="SET_user_reward_3" value="<?php echo $result['SET_user_reward_3']; ?>" placeholder="比列..."/>&nbsp;%
        <span class="errorTips">如：15,10,5 ，请用英文逗号隔开</span>
       </li>	   

       <li>
        <span class="item_name" style="width:120px;">会员升级：</span>
        1级会员购买&nbsp;<input type="text" class="textbox textbox_195" name="SET_buys_1" value="<?php echo $result['SET_buys_1']; ?>" placeholder="数量..."/>&nbsp;乐豆升2级会员，<!--&nbsp;赠送&nbsp;<input type="text" class="textbox textbox_195" name="SET_give_goods_1" value="<?php echo $result['SET_give_goods_1']; ?>" placeholder="数量..."/>台小钻箱，&nbsp;-->赠送&nbsp;<input type="text" class="textbox textbox_195" name="SET_give_coin_1" value="<?php echo $result['SET_give_coin_1']; ?>" placeholder="数量..."/>乐豆种子
       </li>
       <li>
        <span class="item_name" style="width:120px;">&nbsp;</span>
        购买&nbsp;
		<input type="text" class="textbox textbox_195" name="SET_buys_2" value="<?php echo $result['SET_buys_2']; ?>" placeholder="数量..."/>&nbsp;乐豆，<!--&nbsp;赠送&nbsp;<input type="text" class="textbox textbox_195" name="SET_give_goods_2" value="<?php echo $result['SET_give_goods_2']; ?>" placeholder="数量..."/>台小钻箱，&nbsp;赠送&nbsp;--><input type="text" class="textbox textbox_195" name="SET_give_coin_2" value="<?php echo $result['SET_give_coin_2']; ?>" placeholder="数量..."/>
		&nbsp;个乐豆种子
       </li>
       <li>
        <span class="item_name" style="width:120px;">&nbsp;</span>
        购买&nbsp;<input type="text" class="textbox textbox_195" name="SET_buys_3" value="<?php echo $result['SET_buys_3']; ?>" placeholder="数量..."/>&nbsp;乐豆升3级会员，<!--&nbsp;赠送&nbsp;<input type="text" class="textbox textbox_195" name="SET_give_goods_3" value="<?php echo $result['SET_give_goods_3']; ?>" placeholder="数量..."/>台中钻箱，-->赠送&nbsp;
		<input type="text" class="textbox textbox_195" name="SET_give_coin_3" value="<?php echo $result['SET_give_coin_3']; ?>" placeholder="数量..."/>
		&nbsp;个乐豆种子
		
		
		<!--<span>
		&nbsp;直推人赠送<!--<input type="text" class="textbox textbox_195" name="SET_parents_1" value="<?php echo $result['SET_parents_1']; ?>" placeholder="数量..."/>台中型钻箱和&nbsp;--><!--<input type="text" class="textbox textbox_195" name="SET_parents_2" value="<?php echo $result['SET_parents_2']; ?>" placeholder="数量..."/>台小型钻箱
		<!--<span>-->
       </li>	   
	   
       <li>
        <span class="item_name" style="width:120px;">自助排单设置：</span>
        <label class="single_selection"><input type="radio" name="SET_FREE" value="1" <?php if($result['SET_FREE'] == '1'): ?>checked<?php endif; ?> />开启</label>
        <label class="single_selection"><input type="radio" name="SET_FREE" value="0" <?php if($result['SET_FREE'] == '0'): ?>checked<?php endif; ?> />关闭</label>
       </li>
	   
       <li hidden>
        <span class="item_name" style="width:150px;">自助排单时间间隔：</span>
        每&nbsp;<input type="text" class="textbox textbox_195"  name="SET_TIME_SPAN" value="<?php echo $result['SET_TIME_SPAN']; ?>" placeholder="时间间隔..."/>&nbsp;小时，匹配&nbsp;<input type="text" class="textbox textbox_195" name="SET_TIME_WHILE" value="<?php echo $result['SET_TIME_WHILE']; ?>" placeholder="签到收益..."/>&nbsp;小时前的订单
       </li> 
       <li hidden>
        <span class="item_name" style="width:120px;">&nbsp;</span>
		 <span class="errorTips">		
			列如：每间隔3小时匹配一次24小时前的订单，不填为不限制
		 </span>
       </li>	   
	   
       <li>
        <span class="item_name" style="width:150px;">网站开关设置：</span>       
        <label class="single_selection"><input type="radio" name="SET_CLOSE" value="1" <?php if($result['SET_CLOSE'] == '1'): ?>checked<?php endif; ?>/>开放登陆</label>
		<label class="single_selection"><input type="radio" name="SET_CLOSE" value="0" <?php if($result['SET_CLOSE'] == '0'): ?>checked<?php endif; ?> />关闭登陆</label>
       </li>
       <li>
        <span class="item_name" style="width:150px;">站点关闭时间：</span>       
		<input type="text" class="textbox textbox_195" name="SET_start_close" value="<?php echo $result['SET_start_close']; ?>" placeholder="几点..."/>&nbsp;时 &nbsp;至&nbsp;
		<input type="text" class="textbox textbox_195" name="SET_start_open" value="<?php echo $result['SET_start_open']; ?>" placeholder="几点..."/>&nbsp;时
		 <span class="errorTips">		
			提示：请使用24小时制，比如24:30 - 9:30
		 </span>
       </li>
       <li>
        <span class="item_name" style="width:120px;"></span>
        <input type="submit" id="submit" class="link_btn" value="保存"/>
       </li>
	  <!--  </form> -->
      </ul>
     </section>
	 
 </div>
</section>






<script>
$(document).ready(function() {

	$('#submit').click(function(event){
		
		var formData = new FormData(); 
		
		var SET_SING_AMOUNT = $('input[name="SET_SING_AMOUNT"]').val();//签到最低收益总金额
		var SET_SING_PROFIT = $('input[name="SET_SING_PROFIT"]').val();//签到最低收益 元
		var SET_SING_PER = $('input[name="SET_SING_PER"]').val();//签到收益百分比
		var SET_SING_CARD = $('input[name="SET_SING_CARD"]').val();//加速卡收益+
		var SET_CARD_TERM = $('input[name="SET_CARD_TERM"]').val();//加速卡使用期限
		var SET_DAY_PER = $('input[name="SET_DAY_PER"]').val();//日转账交易设置
		
		var SET_CODE_AMOUNT = $('input[name="SET_CODE_AMOUNT"]').val();//兑换码任务 总金额
		var SET_CODE_TEAM = $('input[name="SET_CODE_TEAM"]').val();//兑换码任务 下级人数
		var SET_CODE_NUM = $('input[name="SET_CODE_NUM"]').val();//兑换码任务 赠送数量
		var SET_GOODS_PRICE =  $('input[name="SET_GOODS_PRICE"]').val();//市场鱼苗单价
		
		var SET_FREE = $('input[name="SET_FREE"]:checked').val();//自助排单设置 开启/关闭
		var SET_TIME_SPAN = $('input[name="SET_TIME_SPAN"]').val();//自助排单时间间隔1 每间隔N小时匹配一次
		var SET_TIME_WHILE = $('input[name="SET_TIME_WHILE"]').val();//自助排单时间间隔2 匹配N小时前的订单
		
		var SET_CLOSE = $('input[name="SET_CLOSE"]:checked').val();//站点会员登陆限制
		
		var SET_MARKET_CLOSE = $('input[name="SET_MARKET_CLOSE"]:checked').val();//鱼苗市场设置 开启/关闭
		
		var SET_MIN_BUY =  $('input[name="SET_MIN_BUY"]').val();//最低买入数量
		var SET_MIN_SELL =  $('input[name="SET_MIN_SELL"]').val();//最低卖出数量
		
		var SET_MAX_BUY =  $('input[name="SET_MAX_BUY"]').val();//最高买入数量
		var SET_MAX_SELL =  $('input[name="SET_MAX_SELL"]').val();//最高卖出数量
		var SET_USERSELL_NUM =  $('input[name="SET_USERSELL_NUM"]').val();//最高当天卖出次数
		
		var SET_REG_GIVE =  $('input[name="SET_REG_GIVE"]').val();//注册送鱼苗
		
		var SET_FRY_AMOUNT =  $('input[name="SET_FRY_AMOUNT"]').val();//打捞鱼苗 最低收益总金额
		var SET_FRY_PROFIT =  $('input[name="SET_FRY_PROFIT"]').val();//打捞鱼苗 最低收益 元
		var SET_FRY_PER =  $('input[name="SET_FRY_PER"]').val();//打捞鱼苗 收益百分比
		
		var SET_PAY_AMOUNT =  $('input[name="SET_PAY_AMOUNT"]').val();//团队奖 充值金额
		var SET_REWARD_PER =  $('input[name="SET_REWARD_PER"]').val();//团队奖 领导奖励百分百
		
		var SET_start_close =  $('input[name="SET_start_close"]').val();
		var SET_start_open =  $('input[name="SET_start_open"]').val();
		
		var SET_poundage =  $('input[name="SET_poundage"]').val();
		var SET_usable =  $('input[name="SET_usable"]').val();
		
		var SET_groom_1 =  $('input[name="SET_groom_1"]').val();
		var SET_groom_2 =  $('input[name="SET_groom_2"]').val();
		var SET_groom_3 =  $('input[name="SET_groom_3"]').val();
		var SET_groom_4 =  $('input[name="SET_groom_4"]').val();
		
		var SET_kjnum_1 =  $('input[name="SET_kjnum_1"]').val();
		var SET_kjnum_2 =  $('input[name="SET_kjnum_2"]').val();
		var SET_kjnum_3 =  $('input[name="SET_kjnum_3"]').val();
		var SET_kjnum_4 =  $('input[name="SET_kjnum_4"]').val();
		
		var SET_coin_rate =  $('input[name="SET_coin_rate"]').val();
		
		var SET_unsealing =  $('input[name="SET_unsealing"]').val();
		var SET_unsealing_money =  $('input[name="SET_unsealing_money"]').val();
		
		var SET_paytime_end =  $('input[name="SET_paytime_end"]').val();
		var SET_yestime_end =  $('input[name="SET_yestime_end"]').val();
		
		var SET_buys_1 =  $('input[name="SET_buys_1"]').val();
		var SET_buys_2 =  $('input[name="SET_buys_2"]').val();
		var SET_buys_3 =  $('input[name="SET_buys_3"]').val();
		var SET_give_coin_1 =  $('input[name="SET_give_coin_1"]').val();
		var SET_give_coin_2 =  $('input[name="SET_give_coin_2"]').val();
		var SET_give_coin_3 =  $('input[name="SET_give_coin_3"]').val();
		
		var SET_give_goods_1 =  $('input[name="SET_give_goods_1"]').val();
		var SET_give_goods_2 =  $('input[name="SET_give_goods_2"]').val();
		var SET_give_goods_3 =  $('input[name="SET_give_goods_3"]').val();
		
		var SET_parents_1 =  $('input[name="SET_parents_1"]').val();
		var SET_parents_2 =  $('input[name="SET_parents_2"]').val();
		
		var SET_usable_money =  $('input[name="SET_usable_money"]').val();
		
		var SET_release =  $('input[name="SET_release"]').val();
		
		var SET_user_Grade_1 =  $('input[name="SET_user_Grade_1"]').val();
		var SET_user_reward_1 =  $('input[name="SET_user_reward_1"]').val();
		var SET_user_Grade_2 =  $('input[name="SET_user_Grade_2"]').val();
		var SET_user_reward_2 =  $('input[name="SET_user_reward_2"]').val();
		var SET_user_Grade_3 =  $('input[name="SET_user_Grade_3"]').val();
		var SET_user_reward_3 =  $('input[name="SET_user_reward_3"]').val();
		
		var SET_buy_limit =  $('input[name="SET_buy_limit"]').val();
		var SET_buy_nums =  $('input[name="SET_buy_nums"]').val();
		
		
		formData.append('SET_buys_1',SET_buys_1);
		formData.append('SET_buys_2',SET_buys_2);
		formData.append('SET_buys_3',SET_buys_3);
		formData.append('SET_give_coin_2',SET_give_coin_2);
		formData.append('SET_give_coin_1',SET_give_coin_1);
		formData.append('SET_give_coin_3',SET_give_coin_3);		
		formData.append('SET_give_goods_1',SET_give_goods_1);
		formData.append('SET_give_goods_2',SET_give_goods_2);
		formData.append('SET_give_goods_3',SET_give_goods_3);
		
		formData.append('SET_parents_1',SET_parents_1);
		formData.append('SET_parents_2',SET_parents_2);
		
		
		formData.append('SET_buy_nums',SET_buy_nums);
		formData.append('SET_buy_limit',SET_buy_limit);
		formData.append('SET_user_Grade_1',SET_user_Grade_1);
		formData.append('SET_user_reward_1',SET_user_reward_1);
		formData.append('SET_user_Grade_2',SET_user_Grade_2);
		formData.append('SET_user_reward_2',SET_user_reward_2);
		formData.append('SET_user_Grade_3',SET_user_Grade_3);
		formData.append('SET_user_reward_3',SET_user_reward_3);
		
		formData.append('SET_usable_money',SET_usable_money);
		
		formData.append('SET_release',SET_release);
				
		formData.append('SET_coin_rate',SET_coin_rate); 
		
		formData.append('SET_kjnum_1',SET_kjnum_1); 
		formData.append('SET_kjnum_2',SET_kjnum_2); 
		formData.append('SET_kjnum_3',SET_kjnum_3); 
		formData.append('SET_kjnum_4',SET_kjnum_4); 
		
		formData.append('SET_unsealing',SET_unsealing);
		formData.append('SET_unsealing_money',SET_unsealing_money);
		
		formData.append('SET_paytime_end',SET_paytime_end);
		formData.append('SET_yestime_end',SET_yestime_end);
		
		var SET_usable_coin =  $('input[name="SET_usable_coin"]').val();

		
		
        
		//加入对象
		formData.append('SET_CLOSE',SET_CLOSE);
		formData.append('SET_FREE',SET_FREE);
		formData.append('SET_MARKET_CLOSE',SET_MARKET_CLOSE);
		
		formData.append('SET_groom_1',SET_groom_1);  
		formData.append('SET_groom_2',SET_groom_2);  
		formData.append('SET_groom_3',SET_groom_3);  
		formData.append('SET_groom_4',SET_groom_4);  
		
		formData.append('SET_usable_coin',SET_usable_coin); 
		
		if(SET_usable){
			formData.append('SET_usable',SET_usable);  
		}
		if(SET_poundage){
			formData.append('SET_poundage',SET_poundage);  
		}
		if(SET_start_close){
			formData.append('SET_start_close',SET_start_close);  
		}		
		if(SET_start_open){
			formData.append('SET_start_open',SET_start_open);  
		}
		if(SET_PAY_AMOUNT){
			formData.append('SET_PAY_AMOUNT',SET_PAY_AMOUNT);  
		}
		if(SET_REWARD_PER){
			formData.append('SET_REWARD_PER',SET_REWARD_PER);  
		}
		
		if(SET_FRY_AMOUNT){
			formData.append('SET_FRY_AMOUNT',SET_FRY_AMOUNT);  
		}
		if(SET_FRY_PROFIT){
			formData.append('SET_FRY_PROFIT',SET_FRY_PROFIT);  
		}
		if(SET_FRY_PER){
			formData.append('SET_FRY_PER',SET_FRY_PER);  
		}
		
		if(SET_REG_GIVE){
			formData.append('SET_REG_GIVE',SET_REG_GIVE);  
		}
		
		if(SET_MIN_BUY){
			formData.append('SET_MIN_BUY',SET_MIN_BUY);  
		}
		if(SET_MIN_SELL){
			formData.append('SET_MIN_SELL',SET_MIN_SELL);  
		}
		if(SET_MAX_BUY){
			formData.append('SET_MAX_BUY',SET_MAX_BUY);  
		}
		if(SET_MAX_SELL){
			formData.append('SET_MAX_SELL',SET_MAX_SELL);  
		}
		
		if(SET_USERSELL_NUM){
			formData.append('SET_USERSELL_NUM',SET_USERSELL_NUM);  
		}
		
		if(SET_DAY_PER){
			formData.append('SET_DAY_PER',SET_DAY_PER);  
		}
		if(SET_CARD_TERM){
			formData.append('SET_CARD_TERM',SET_CARD_TERM);  
		}
		if(SET_SING_CARD){
			formData.append('SET_SING_CARD',SET_SING_CARD);  
		}
		if(SET_SING_PER){
			formData.append('SET_SING_PER',SET_SING_PER);   
		}
		if(SET_SING_PROFIT){
			formData.append('SET_SING_PROFIT',SET_SING_PROFIT);  
		}
		if(SET_SING_AMOUNT){
			formData.append('SET_SING_AMOUNT',SET_SING_AMOUNT); 
		}
		
		if(SET_CODE_AMOUNT){
			formData.append('SET_CODE_AMOUNT',SET_CODE_AMOUNT);   
		}
		if(SET_CODE_TEAM){
			formData.append('SET_CODE_TEAM',SET_CODE_TEAM);  
		}
		if(SET_CODE_NUM){
			formData.append('SET_CODE_NUM',SET_CODE_NUM); 
		}	

		if(SET_GOODS_PRICE){
			formData.append('SET_GOODS_PRICE',SET_GOODS_PRICE); 
		}		
		
		if(SET_TIME_SPAN){
			formData.append('SET_TIME_SPAN',SET_TIME_SPAN); 
		}
		if(SET_TIME_WHILE){
			formData.append('SET_TIME_WHILE',SET_TIME_WHILE); 
		}
		

		formData.append('op','userset/edit');		
			   
		//console.log(formData.get("op"));
		
		$.ajax({
			url:"<?php echo url('users/uset_edit'); ?>",
			dataType:"json",
			type:'POST',
			cache:false,
			processData: false,//用于对data参数进行序列化处理 这里必须false
            contentType: false, //必须
			data:formData,
			success: function(data) {
				console.log(data);
				if (data.s=='ok') {
					myAlert('修改成功');
					setTimeout(function(){
					//页面刷新  
					window.location.reload();
					},1000);
					
				}else {
					myAlert(data.s);
				}
			}
		});
	});  
	
});
</script>
	
    </body>
</html>