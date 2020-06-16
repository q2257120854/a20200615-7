<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:79:"D:\wwwroot\yoopay.top\public/../application/admincmsby\view\trade\buyorder.html";i:1558789725;s:75:"D:\wwwroot\yoopay.top\public/../application/admincmsby\view\index\base.html";i:1557824309;s:78:"D:\wwwroot\yoopay.top\public/../application/admincmsby\view\public\header.html";i:1557838008;s:76:"D:\wwwroot\yoopay.top\public/../application/admincmsby\view\public\left.html";i:1560258805;s:78:"D:\wwwroot\yoopay.top\public/../application/admincmsby\view\public\footer.html";i:1524125862;}*/ ?>
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
.paging{
   margin-top:30px;
}
.home{
	color:#fff;border: 1px #b6b6b6 solid;background: #b6b6b6; padding: 15px;height: 38px;line-height: 38px;
}
.all{
	color:#fff;border: 1px #999 solid;background: #999; padding: 15px;height: 38px;line-height: 38px;
}
.market_s{
	color:#fff;border: 1px #ff7600 solid;background: #ff7600; padding: 15px;height: 38px;line-height: 38px;
}
.market_submit{
	color:#fff;border: 1px #0089ff solid;background: #0089ff; padding: 15px;height: 38px;line-height: 38px;
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
       <h2 class="fl">买入订单</h2>
      </div>
      <section class="mtb">
	   <form action="" method="get" >
		&nbsp;&nbsp;状态	
	   <select class="select" name="status">
			<option value="0">&nbsp;&nbsp;&nbsp;选择&nbsp;&nbsp;&nbsp;</option>
			<option value="1" <?php if($status == '1'): ?>selected<?php endif; ?>>&nbsp;&nbsp;&nbsp;冻结&nbsp;&nbsp;&nbsp;</option>
			<option value="2" <?php if($status == '2'): ?>selected<?php endif; ?>>&nbsp;&nbsp;&nbsp;成功交易&nbsp;&nbsp;&nbsp;</option>
			<option value="3" <?php if($status == '3'): ?>selected<?php endif; ?>>&nbsp;&nbsp;&nbsp;等待中&nbsp;&nbsp;&nbsp;</option>
			<option value="4" <?php if($status == '4'): ?>selected<?php endif; ?>>&nbsp;&nbsp;&nbsp;完成匹配&nbsp;&nbsp;&nbsp;</option>
			<option value="5" <?php if($status == '5'): ?>selected<?php endif; ?>>&nbsp;&nbsp;&nbsp;取消&nbsp;&nbsp;&nbsp;</option>

       </select>
	   
	   &nbsp;&nbsp;次数	
	   <select class="select" name="number">
			<option value="0">&nbsp;&nbsp;&nbsp;选择&nbsp;&nbsp;&nbsp;</option>
			<option value="1" <?php if($status == '1'): ?>selected<?php endif; ?>>&nbsp;&nbsp;&nbsp;第一次&nbsp;&nbsp;&nbsp;</option>
			<option value="2" <?php if($status == '2'): ?>selected<?php endif; ?>>&nbsp;&nbsp;&nbsp;第二次&nbsp;&nbsp;&nbsp;</option>
			<option value="3" <?php if($status == '3'): ?>selected<?php endif; ?>>&nbsp;&nbsp;&nbsp;第三次&nbsp;&nbsp;&nbsp;</option>
			<option value="4" <?php if($status == '4'): ?>selected<?php endif; ?>>&nbsp;&nbsp;&nbsp;老会员&nbsp;&nbsp;&nbsp;</option>

       </select>
	   
	   &nbsp;&nbsp;会员账号
       <input type="text" class="textbox textbox_125" placeholder="输入会员账号..." name="keyword" value="<?php echo $keyword; ?>" />
	   &nbsp;&nbsp;订单号
	    <input type="text" class="textbox textbox_125" placeholder="输入订单号..." name="orderid" value="<?php echo $orderid; ?>" />
       <input type="submit" value="查询" class="group_btn"/>
	   <a href="<?php echo url('trade/buyorder'); ?>?style=1" class="home"/>官方委托购买</a>
	   <a href="<?php echo url('trade/buyorder'); ?>?style=2" class="home"/>自助排单</a>
	   <a href="<?php echo url('trade/buyorder'); ?>" class="all"/>全部</a>
		<?php if($sellid == ''): ?>
			<a href="javascript:;" class="market_s"/>匹配</a>
	   <?php else: ?>
			<a href="javascript:;" class="market_submit"/>匹配确认</a>
	   <?php endif; ?>
	   </form>
      </section>
      <table class="table">
       <tr>
        <th style="width:80px;">ID</th>		
		<th>订单号</th>
		<th>会员账号</th>
		<th>单价</th>
		<th>数量</th>
		<th>总金额</th>
		<th>交易方式</th>
		<th>状态</th>
		<th>匹配时间</th>
		<th>完成时间</th>
		<th>添加时间</th>
        <th>操作</th>
       </tr>
       </tr>
	   <?php if(is_array($volist['data']) || $volist['data'] instanceof \think\Collection || $volist['data'] instanceof \think\Paginator): if( count($volist['data'])==0 ) : echo "" ;else: foreach($volist['data'] as $key=>$vo): ?>
       <tr class="id_<?php echo $vo['id']; ?>">
        <td class="center"><input type="checkbox" value="<?php echo $vo['id']; ?>" name="id" /><?php echo $vo['id']; ?></td>
		<td class="center"><?php echo $vo['orderid']; ?></td>
        <td class="center">
			<?php echo $vo['username']; ?>
		</td>
        <td class="center">
			￥<?php echo $vo['price']; ?>
		</td>
        <td class="center">
			<?php echo $vo['amount']; ?>
		</td>
        <td class="center">
			￥
			<span style="color:red"><?php echo $vo['total_money']; ?></span>
		</td>
        <td class="center">
			<?php if($vo['style'] == '0'): ?>
				<span style="color:#000;">官方委托购买</span>
			<?php endif; if($vo['style'] == '1'): ?>
				<span style="color:#000;">自助排单</span>
			<?php endif; ?>
		</td>
		<td class="center">
			<?php if($vo['status'] == '0'): ?>
				<span style="color:red">冻结</span>
			<?php endif; if($vo['status'] == '1'): ?>
				<span style="color:green">成功交易</span>
			<?php endif; if($vo['status'] == '2'): ?>
				<span style="color:#3c7fff">等待中</span>
			<?php endif; if($vo['status'] == '3'): ?>
				<span style="color:#0091e8;">完成匹配</span>
			<?php endif; if($vo['status'] == '4'): ?>
				<span style="color:red">已取消</span>
			<?php endif; ?>
			
			
		</td>
		
        <td class="center">
		<?php if($vo['matetime'] != '0'): ?>
			<?php echo date("Y-m-d H:i:s",$vo['matetime']); else: ?>
			--
		<?php endif; ?>	
		</td>	
		<td class="center">
		<?php if($vo['endtime'] != '0'): ?>
			<?php echo date("Y-m-d H:i:s",$vo['endtime']); else: ?>
			--
		<?php endif; ?>
		</td>
			
		<td class="center"><?php echo date("Y-m-d H:i:s",$vo['addtime']); ?></td>	
        <td class="center">
        <a href="#" title="拆分订单" class="link_icon split" data-id="<?php echo $vo['id']; ?>" data-orderid="<?php echo $vo['orderid']; ?>"  data-status="<?php echo $vo['status']; ?>" style="font-size:14px;">拆分订单</a>
         <a href="#" title="删除" class="link_icon del" data-id="<?php echo $vo['id']; ?>">&#100;</a>
        </td>
       </tr>
		<?php endforeach; endif; else: echo "" ;endif; ?>
      </table>
	  <div>
		<aside class="paging_left">
		   <a id="all">全选</a>
		   <a id="nocheck">取消</a>
		   <a id="reverse">反选</a>
		   <a id="delid">删除</a>
		</aside>
	  <?php echo $list->render(); ?>
	 </div>
 </div>
</section>







<script>
$(document).ready(function() {
	//全选
	$("#all").on('click', function() {
		//全选选中为true，否则为false
		$("input[type=checkbox]").each(function(){ 
		//循环checkbox选择或取消
			$(this).prop("checked",true);
		});
	});
	//取消
	$("#nocheck").on('click', function() {
		$("input[type=checkbox]").each(function(){ 
			$(this).prop("checked",false);
		});
	});
	//反选
	$("#reverse").click(function () { 
		$("table :checkbox").each(function () {  
			$(this).prop("checked", !$(this).prop("checked"));  
		});
	});
	//拆分订单	
	$('.split').click(function(event){
		var id = $(this).attr('data-id');
		var orderid = $(this).attr('data-orderid');
		var status = $(this).attr('data-status');
		if(id){
			if (confirm("确定要拆分订单<"+orderid+">吗？")) {
				if(status!="2"){
					myAlert('该订单状态不能进行拆分操作');return false;
				}
				var url = "<?php echo url('trade/splitOrder'); ?>?type=buy&id="+id;
				//跳转到买入订单页面
				window.location.href = url;	
			}		
		
		}else{
			myAlert('请选择要拆分的订单');return false;
		}
	});
	//删除
	$('.del').click(function(event){
		var id = $(this).attr('data-id');
		if (confirm("确定要删除吗？")) {
			$.ajax({
				url:"<?php echo url('trade/buyorder_del'); ?>",
				dataType:"json",
				type:'POST',
				cache:false,
				data:{op:'buyorder/del_nucm',id:id},
				success: function(data) {
					console.log(data.s);
					if (data.s=='ok') {				
						myAlert('删除成功');
						setTimeout(function(){
							//页面刷新  
							window.location.reload();
						},1000);
					}else {
						myAlert(data.s);
					}
				}
			});		
		}
	}); 
    //批量删除
	$('#delid').click(function(event){
		var id=new Array();  
		$('input[name="id"]:checked').each(function(){  
			id.push($(this).val());//向数组中添加元素  
		});  
		var id_str = id.join(',');//将数组元素连接起来以构建一个字符串 
		if (confirm("确定要删除吗？")) {
			$.ajax({
				url:"<?php echo url('trade/buyorder_delmost'); ?>",
				dataType:"json",
				type:'POST',
				cache:false,
				data:{op:'buyorder/DelAll_nucm',delid:id_str,pid:0},
				success: function(data) {
					console.log(data.s);
					if (data.s=='ok') {				
						myAlert('删除成功');
						setTimeout(function(){
						//页面刷新  
						window.location.reload();
						},1000);
					}else {
						myAlert(data.s);
					}
				}
			});
		}
	});

	//订单匹配 market_s
	$('.market_s').click(function(event){
		var id=new Array();  
		$('input[name="id"]:checked').each(function(){  
			id.push($(this).val());//向数组中添加元素  
		});
		if(!id){
			myAlert('请选择要匹配的订单');return false;
		}
		//只能单选
		if(isNaN(id)){
			myAlert('只能一次匹配一张订单');return false;
		}
		id = $('input[name="id"]:checked').val();
		var url = "<?php echo url('trade/sellorder'); ?>?market_buyid="+id;
		//console.log(id);return false;
		
		//判断订单是否存在
		$.ajax({
			url:"<?php echo url('trade/checked_order'); ?>",
			dataType:"json",
			type:'POST',
			cache:false,
			data:{op:'checked/order',id:id,type:'buy'},
			success: function(data) {
				
				if (data.s=='ok') {	
					//跳转到买入订单页面
					window.location.href = url;
				}else {
					myAlert(data.s);
				}
			}
		});
		
	});	
	
	//订单匹配 market_submit
	$('.market_submit').click(function(event){
		var id=new Array();  
		$('input[name="id"]:checked').each(function(){  
			id.push($(this).val());//向数组中添加元素  
		});
		var id_str = id.join(',');
		if(!id_str){
			myAlert('请选择要匹配的订单');return false;
		}
		//console.log(id_str);return false;
		
		var url = "<?php echo url('trade/market'); ?>";
		
			$.ajax({
				url:"<?php echo url('trade/market_matching'); ?>",
				dataType:"json",
				type:'POST',
				cache:false,
				data:{op:'checked/order',arrid:id_str,type:'sell',id:"<?php echo $sellid; ?>"},
				success: function(data) {
					console.log(data.s);
					if (data.s=='ok') {				
						myAlert('匹配成功');
						setTimeout(function(){
						//页面刷新  
						window.location.href = url;
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