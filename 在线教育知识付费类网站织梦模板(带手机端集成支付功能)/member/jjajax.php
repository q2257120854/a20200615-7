<?php
require_once(dirname(__FILE__)."/config.php");
$mid  = $cfg_ml->M_ID;

//九戒织梦 获取权限
if($a == 'GetRank'){
	
	if(empty($mid)){
		die('notlogin');
	}
	
 	if($cfg_ml->M_Rank == 500){
		echo 'ok';
	}else{
		//不是会员看看有没有买过这个课程
		$arr = $dsql->GetOne("select * from  `#@__shops_orders` where userid = '$mid' and pid = '$tid' and state = '1' ");
		if(empty($arr['oid'])){
			echo 'no';
		}else{
			echo 'ok';
		}
		
	}
	exit();
}


//九戒织梦 收藏
if($a == 'typestow'){
	if(empty($mid)){
		die('notlogin');
	}else{
$arr = $dsql->GetOne("select id from #@__mytypestow where tid = '$tid' and mid = '$mid'");
$time = time();
if(empty($arr['id'])){
	$dsql->ExecuteNoneQuery("insert into #@__mytypestow (`tid`,`mid`,`time`) values ('$tid','$mid','$time')");
	die('ok');
}else{
	$dsql->ExecuteNoneQuery("delete from #@__mytypestow  where id = '".$arr['id']."'");
	die('no');
}

}
exit();
}

//九戒织梦 栏目收藏状态
if($a == 'GetTypeStow'){
$arr = $dsql->GetOne("select id from #@__mytypestow where tid = '$tid' and mid = '$mid'");
if(!empty($arr['id'])){
	echo('ok');
}
	exit();
}


?>