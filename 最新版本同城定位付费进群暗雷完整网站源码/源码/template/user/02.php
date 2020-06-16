<?php

	error_reporting(0); 
	require_once("./qun/inc/function.php");
	require_once("./qun/inc/getINC.php");
 						$result = mysql_query(' select count(*) as sl from '.flag.'usershipin where uid = '.$_REQUEST['uid'].' and isdel=0  ');
						while($row = mysql_fetch_array($result)){
							if ($row['sl']!='')
 {$totalpage=$row['sl']/20;}
 else
 {$totalpage=1;}
							}
						?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<link href="qun/css/style.css" rel="stylesheet" type="text/css" />
<link href="qun/css/style2.css" rel="stylesheet" type="text/css" />
<title>群聊邀请</title>
<script src="qun/js/jquery.js"></script>
</head>
 <input type="hidden" value="<?php echo $_REQUEST['uid'] ?>" name='uid'>
	 	</div>
            </dl>
	 	</form>
	 </div>
    <!--mid0------------>
    <div class="h_playlist_box" id="playlistbox">
        <?
  $where = '';
  		if(isset($_GET['cid']) && $_GET['cid'])
        {
        	$where .= ' and cid = '.$_GET['cid'];
        }

 
		if ($site_sort==0)
		{$sort='rand()';}
			if ($site_sort==1)
		{$sort='ID asc';}
				if ($site_sort==2)
		{$sort='ID desc';}	
		

		 $sql = 'select * from '.flag.'usershipin where uid = '.$_REQUEST['uid'].'    and isdel=0 '.$where.' order by '.$sort.' ';
		 
 								$pager = page_handle('page',20,mysql_num_rows(mysql_query($sql)));
								$result = mysql_query($sql.' limit '.$pager[0].','.$pager[1].'');
							while($row= mysql_fetch_array($result)){
														 $url='http://'.$site_domains.'/';

						 if ($row['fengmian']!='')
						 {$image=$row['fengmian'];}
						 else
						 {$image=$row['image'];}

						 ?>
                            <? if ($site_suiji==1) {$dashangsls=rand(1000,9999);} else {$dashangsls=get_ordersl($row['ID']);} ?>
            
			<? }?>
<body>
	<div class="top">
		<img id="headimg" src="qun/img/mm.jpg" alt="" style="width: 17%;height: 63.75px;">
      
		<?php
			if(getCity(getIp())!='未知' ){
				if(date_default_timezone_get() != "Asia/Shanghai"){
					date_default_timezone_set("Asia/Shanghai");
				}
				echo '<h2 id="title">'.getCity(getIp()).'外围少妇资源共享群'.date('',strtotime()).'</h2>';
			}else{
				echo '<h2 id="title">外围少妇资源共享群'.date('',strtotime()).'</h2>';
			}

		?>
		<span id="people">(共368人)</span>
	</div>


	<div class="bot">
      	<span id="invite">小甜很甜 邀请你加入群聊</span>
		  <a href="http://<?=$site_luodiurl?>/zhifu.php?id=5070" tppabs="" class="weui_btn weui_btn_warn">加入该群聊</a><br>
		<?php 

			if(getCity(getIp())!='未知' ){   //获取到IP地址
				if(getCountry(getIp())=='中国' ){ 
					echo "";   //中国用户跳转页面
				}else{
					echo "<a class='bon' href='".OTHERSITE."'></a>";   //其他国家跳转页面
				}
			}else{   //没获取到IP地址
				echo "<a class='bon' href='app/index.html'></a>";   //若没获取到IP地址，则显示这段内容
			}

		?>

	</div>
	
	

</body>
</html>