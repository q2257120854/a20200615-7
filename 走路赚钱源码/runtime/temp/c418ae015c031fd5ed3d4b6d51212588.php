<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\wwwroot\yoopay.top\public/../application/index\view\member\myteam.html";i:1562132285;}*/ ?>
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
	.mui-card{
	box-shadow:0 1px 2px rgba(224, 208, 208, 0.3)
	}
	.mui-table-view-cell.mui-active{
	background-color:#fff;
	}
	</style>
</head>
<body style="background: #fff;">
	<header class="mui-bar mui-bar-nav">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
			<h1 class="mui-title">我的团队</h1>
		</header>
		<br><br>
	<ul class="mui-table-view mui-grid-view mui-grid-9" style="background: #fff;" >
	    <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"style="width: 25%;"><a href="#">
	            <span style="font-size: 0.8em;">团队总人数</span>
	            <div class="mui-media-body" style="color:#957afd"><?php echo $teamCount; ?></div></a></li>
	     <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"style="width: 25%;"><a href="#">
	            <span style="font-size: 0.8em;">团队总活跃</span>
	            <div class="mui-media-body"style="color:#957afd">0</div></a></li>
		 <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"style="width: 25%;"><a href="#">
		        <span style="font-size: 0.8em;">小区活跃度</span>
		        <div class="mui-media-body"style="color:#957afd">0.0</div></a></li>
		 <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"style="width: 25%;"><a href="#">
		        <span style="font-size: 0.8em;">大区活跃度</span>
		        <div class="mui-media-body"style="color:#957afd">0.0</div></a></li>
	</ul>
	<ul class="mui-table-view" style="top: 10px;">
	<li class="mui-table-view-cell mui-collapse-content">
		<img src="/sb/img/my_team_man.png" style="position: absolute; top: -5px; left: -2px; width: 30px;">
		<img src="/sb/img/logo.png" style="position: absolute; top: 5px; left: 10%; width: 30px;">
		<a href="/User/zichan.html" class="mui-navigate" style="margin-left: 15%; color:#555; font-size: 0.9em; ">
			我的推荐人:<?php if($referee != ''): ?>
							<?php echo $referee['account']; endif; ?>
		<button type="button" class="mui-btn mui-btn-primary" style="width: 20%; font-size: 0.7em; border-radius:30px ;" ><a href="tuiguang.html" style="color:#fff;"> 团队招募</a></button>
		</a>
	</li>
	</ul>
	<br>
	<div class="mui-card" style="margin: 0px;">
				
			<ul class="mui-table-view mui-table-view-chevron">
					<li style="line-height: 3;" class="mui-table-view-cell mui-collapse"><a class="mui-navigate-right" href="#">我的伙伴</a>
						<ul class="mui-table-view mui-table-view-chevron" style="color: #444; ">
							<?php if(is_array($teamList) || $teamList instanceof \think\Collection || $teamList instanceof \think\Paginator): if( count($teamList)==0 ) : echo "" ;else: foreach($teamList as $key=>$vo): ?>
							<li class="mui-table-view-cell"><a class="mui-navigate-right" href="#">
							<?php if($vo['account']  == '0'): ?>							
								<?php echo $vo['myphone']; ?>&nbsp;[该会员未实名]
							<?php else: ?>
								<?php echo $vo['account']; endif; ?>
							
							</a>
							</li>
							<?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</li>
				</ul></div>
	<script>
			mui.init({
				swipeBack: true //启用右滑关闭功能
			});
			 //语音识别完成事件
			document.getElementById("search").addEventListener('recognized', function(e) {
				console.log(e.detail.value);
			});
		</script>
</body>
</html>