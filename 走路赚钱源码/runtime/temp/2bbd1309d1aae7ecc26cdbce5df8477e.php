<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:79:"D:\wwwroot\yoopay.top\public/../application/admincmsby\view\users\recharge.html";i:1562141771;s:75:"D:\wwwroot\yoopay.top\public/../application/admincmsby\view\index\base.html";i:1557824309;s:78:"D:\wwwroot\yoopay.top\public/../application/admincmsby\view\public\header.html";i:1557838008;s:76:"D:\wwwroot\yoopay.top\public/../application/admincmsby\view\public\left.html";i:1560258805;s:78:"D:\wwwroot\yoopay.top\public/../application/admincmsby\view\public\footer.html";i:1524125862;}*/ ?>
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

    <script type="text/javascript" charset="utf-8" src="__STATIC__/umeditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="__STATIC__/umeditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="__STATIC__/umeditor/lang/zh-cn/zh-cn.js"></script>
    <style type="text/css">
        div#content{
			text-align: right;
			margin-left:120px; 	
			width:80%;
        }
		.textbox_640{
			width:640px;
		}
		.ulColumn2{
			margin-bottom:50px;
		}
		.uploadImg,.texlong{
			position:static;
		}
		.page_title{
			height: 45px;
			line-height: 40px;
			width:86%;
			position:fixed;
			top:0;
			margin-top:70px;
			background-color:#fff;			
		}
		.page_title .top_rt_btn{
			margin-right:1rem;
			margin-top:5px;
		}
		.ulColumn2{
			margin-top:70px;
		}
		/*** guide ***/
		.guide{width:60px;margin-left:570px;position:fixed;left:56%;bottom:134px;_position:absolute;_top:expression(documentElement.scrollTop+documentElement.clientHeight - this.clientHeight - 134+'px');display:block;}
		.guide a{display:block;width:60px;height:50px;background:url(__IMG__/sprite_v2.png) no-repeat;margin-top:10px;text-decoration:none;font:16px/50px "Microsoft YaHei";text-align:center;color:#fff;border-radius:2px;}
		.guide a span{display:none;text-align:center;}
		.guide a:hover{text-decoration:none;background-color:#39F;color:#fff;}
		.guide a:hover span{display:block;width:60px;background:#39F}
		.guide .find{background-position:-84px -236px;}
		.guide .report{background-position:-146px -236px;}
		.guide .edit{background-position:-83px -185px;}
		.guide .top{background-position:-145px -185px;}
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
		<h2 class="fl">会员充值</h2>
      </div>

      <ul class="ulColumn2">

       <li>
        <span class="item_name" style="width:120px;">充值会员账号：</span>
        <input type="text" class="textbox textbox_225" value="" name="account" placeholder="充值会员账号..."/>
		<span style="color:red;">*必填</span>
       </li>
       <li>
        <span class="item_name" style="width:120px;">充值钱包类型：</span>
			<label class="single_selection"><input type="radio" name="type" value="1" checked />乐豆钱包</label>
			<label class="single_selection"><input type="radio" name="type" value="2" />乐豆钱包</label>
			<label class="single_selection"><input type="radio" name="type" value="3" />POW额度钱包</label>
		&nbsp;&nbsp;<span style="color:red;">*必填 请选择充值钱包</span>
       </li>		   
       <li>
        <span class="item_name" style="width:120px;">充值金额：</span>
        <input type="text" class="textbox" value="" name="money_on" placeholder="充值金额..."/>&nbsp;&nbsp;元&nbsp;&nbsp;<span style="color:#717171;">充值总额</span>
       </li>	   

       <li>
        <span class="item_name" style="width:120px;"></span>
        <input type="submit" id="submit" class="link_btn submit" value="确认充值"/>
		
       </li>
      </ul>
	  
		<div class="guide">
			<div class="guide-wrap">
				<a href="javascript:;" class="top" title="回顶部"><span>回顶部</span></a>
			</div>
		</div>
		
 </div>
</section>







<script>
//建立一個可存取到該file的url
function getObjectURL(file) {
	var url = null ;
	if (window.createObjectURL!=undefined) { // basic
		url = window.createObjectURL(file) ;
	} else if (window.URL!=undefined) { // mozilla(firefox)
		url = window.URL.createObjectURL(file) ;
	} else if (window.webkitURL!=undefined) { // webkit or chrome
		url = window.webkitURL.createObjectURL(file) ;
	}
	return url ;
}
</script>

<script>

$(document).ready(function() {	
	
	$(".uploadImg").on("change",function(){
		//获取图片的路径，该路径不是图片在本地的路径
		var objUrl = getObjectURL($('input[name="pic"]')[0].files[0]) ; 
		console.log(objUrl);
		if (objUrl) {
			//将图片路径存入src中，显示出图片
			$("#pic").attr("src", objUrl) ; 
		}
	});

	$('.submit').click(function(event){
		var formData = new FormData(); 
		var account = $('input[name="account"]').val();//会员账号
		var money_on = $('input[name="money_on"]').val();//充值金额	
		var type = $('input[name="type"]:checked').val();//钱包类型	
		//return false;
		//加入对象
		
		formData.append('type',type); 
		if(account){
			formData.append('account',account);  
		}else{
			myAlert('充值会员账号不能为空');return false;
		}

		if(money_on){
			formData.append('money_on',money_on);   
		}else{
			myAlert('充值金额不能为空');return false;
		}
		
		formData.append('op','user/recharge_cmmu');
		
		$.ajax({
			url:"<?php echo url('users/recharge_do'); ?>",
			dataType:"json",
			type:'POST',
			cache:false,
			processData: false,//用于对data参数进行序列化处理 这里必须false
            contentType: false, //必须
			data:formData,
			success: function(data) {
				console.log(data);
				if (data.s=='ok') {
					myAlert('充值成功');
					setTimeout(function(){
					//页面刷新  
					//window.history.back(-1); 
					location.href= "<?php echo url('users/recharge_log'); ?>";
					},1000);				
				}else {
					myAlert(data.s);
				}
			}
		});
	});  
	
});

</script>

<script>
	$('.top').click(function(){
		//console.log(111);
		//动画效果，平滑滚动回到顶部
		$('#mCSB_2_container').css('top',0);
		$("#mCSB_2_dragger_vertical").css('top',0);
	})
</script>

	
    </body>
</html>