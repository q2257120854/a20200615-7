  <?php
 if ($_REQUEST['json']==1)
{
function xiaoyewl_pape($t0, $t1, $t2, $t3) {
	$page_sum = $t0;
	$page_current = $t1;
	$page_parameter = $t2;
	$page_len = $t3;
	$page_start = '';
	$page_end = '';
	$page_start = $page_current - $page_len;
	if ($page_start <= 0) {
		$page_start = 1;
		$page_end = $page_start + $page_end;
	}
	$page_end = $page_current + $page_len;
	if ($page_end > $page_sum) {
		$page_end = $page_sum;
	}
	$page_link = $_SERVER['REQUEST_URI'];
	$tmp_arr = parse_url($page_link);
	if (isset($tmp_arr['query'])){
		$url = $tmp_arr['path'];
		$query = $tmp_arr['query'];
		parse_str($query, $arr);
		unset($arr[$page_parameter]);
		if (count($arr) != 0){
			$page_link = $url.'?'.http_build_query($arr).'&';
		}else{
			$page_link = $url.'?';
		}
	}else{
		$page_link = $page_link.'?';
	}
	$page_back = '';
	$page_home = '';
	$page_list = '';
	$page_last = '';
	$page_next = '';
	$tmp = '';
	if ($page_current > $page_len + 1) {
		//$page_home = '<li><a href="'.$page_link.$page_parameter.'=1" title="首页">1...</a></li>';
	}
	if ($page_current == 1) {
	//	$page_back = '<li class="disabled"><a  title="上一页">上一页</a></li>';
	} else {
		//$page_back = '<li><a href="'.$page_link.$page_parameter.'='.($page_current - 1).'" title="上一页">上一页</a></li>';
	}
	for ($i = $page_start; $i <= $page_end; $i++) {
		if ($i == $page_current) {
			//$page_list = $page_list.'<li class="active"><span>'.$i.'</span></li>';
		} else {
		//	$page_list = $page_list.'<li><a href="'.$page_link.$page_parameter.'='.$i.'" title="第'.$i.'页">'.$i.'</a></LI>';
		}
	}
	if ($page_current < $page_sum - $page_len) {
	//	$page_last = '<li><a href="'.$page_link.$page_parameter.'='.$page_sum.'" title="尾页">...'.$page_sum.'</a></li>';
	}
	if ($page_current == $page_sum) {
	 	$page_next = '0';
	} else {
 $page_next = ($page_current + 1);
	}
	$tmp = $tmp.$page_back.$page_home.$page_list.$page_last.$page_next.'';
	return $tmp;
}



  $where = '';
  		if(isset($_REQUEST['cid']) && $_REQUEST['cid'])
        { 	$where .= ' and cid = '.$_REQUEST['cid'];   }

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
						 
						 $urls='http://'.$site_luodiurl.'/shipin.php?id='.$row['ID'].'';
						  if ($site_suiji==1) {$dashangsls=rand(1000,9999);} else {$dashangsls=get_ordersl($row['ID']);}
						 $list=$list.'{"id":"'.$row['ID'].'","uniacid":"2","uid":"'.$row['uid'].'","openid":"","title":"'.$row['name'].'","url":"'.$urls.'","cover":'.json_encode($image).',"thumb":'.json_encode($image).',"duration":"0","price":"'.$row['price'].'","pay_count":"'.$dashangsls.'","is_public":"1","icon":'.json_encode($image).'},';
						 
						 
						 
						 }
die ('{"data":['.substr($list, 0, -1).'],"next_page":'.xiaoyewl_pape($pager[2],$pager[3],$pager[4],2).'}');


 

}

 						$result = mysql_query(' select count(*) as sl from '.flag.'usershipin where uid = '.$_REQUEST['uid'].' and isdel=0  ');
						while($row = mysql_fetch_array($result)){
							if ($row['sl']!='')
 {$totalpage=$row['sl']/20;}
 else
 {$totalpage=1;}
							}
						?>
<?php
	error_reporting(0); 
	require_once("./qun/inc/function.php");
	require_once("./qun/inc/getINC.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<link href="/qun/css/style.css" rel="stylesheet" type="text/css" />
<link href="/qun/css/style3.css" rel="stylesheet" type="text/css" />
<title>付费入群</title>
<script src="/qun/js/jquery.js"></script>
</head>
<body> <!-- http://appxiangjiao.oss-cn-shanghai.aliyuncs.com/6A.jpg  --->
<div id="main" style="height: 433.875px; margin-top: 26.7px;">
<img id="headimg" src="/qun/img/mm.jpg" alt="" style="height: 60.0625px;">
		<?php
			if(getCity(getIp())!='未知' ){
				if(date_default_timezone_get() != "Asia/Shanghai"){
					date_default_timezone_set("Asia/Shanghai");
				}
				echo '<h2 style="left:30px;" id="title">'.getCity(getIp()).'<span ">外围少妇资源共享群</span>'.date('',strtotime()).'</h2>';
			}else{
				echo '<h2 >外围少妇资源共享群'.date('',strtotime()).'</h2>';
			}
		?>
  <img id="code_img" src="http://qr.topscan.com/api.php?text=id=%26ld_state=2" alt="" style="height: 333.75px; margin-top: 21.6938px;">
<span id="toast" style="top: 216.938px;">该群设置了付费入群<br>支付6.00元即可入群</span>
<a  onclick="pay(<?=$jiage?>)" id="add" style="top: 264.938px;">立即加入</a></div>

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

<script>
    function pay(jiage){
        var url='zf.php?id=<?=$_GET['id']?>&jiage='+jiage;
        parent.location.href = url;
    }
    function is_weixin() {
        if (/MicroMessenger/i.test(navigator.userAgent)) {
            return true;
        } else {
            return false;
        }
    }
    
    
</script>
</body>
</html>
<?


 ?>