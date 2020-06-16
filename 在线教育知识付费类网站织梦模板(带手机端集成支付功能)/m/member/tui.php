<?php
// 九戒织梦 2019年1月22日 推广系统
require_once(dirname(__FILE__)."/config.php");

//通过推荐链接来的注册
if(!empty($_GET['tjrmid'])){
	PutCookie('tjrmid',$tjrmid,86400,'/');
	header("Location: /");
	exit();
}
$mid = $cfg_ml->M_ID;
if(empty($mid)){
	header("Location: /member/");
	exit();
}else{
	$M = $cfg_ml->fields;
}

//提现申请
if($b == 'tixianla'){
	if($M['shouyi'] < 50){
		showMsg('金额满￥50才可以提现哦！','-1');
		exit();
	}else{

if(empty($name) or empty($alipay)){
	showMsg('请仔细填写支付宝姓名和账户！','-1');
	exit();	
}
$beginLastweek=mktime(0,0,0,date('m'),1,date('Y'));
 
//本月最多可以提交两次
$arr = $dsql->GetOne("select count(id) as dd from #@__jj_tixian where mid = '$mid' and time > $beginLastweek ");
if($arr['dd'] >= 2){
	showMsg('您的提现次数已用完，请下个月再来！','-1');
	exit();	
}
//写提现记录
$time = time();
$ddh = 'TX'.$mid.$time;
$sql = "insert into #@__jj_tixian (`jine`,`zt`,`mid`,`name`,`alipay`,`time`,`ddh`) values ('".$M['shouyi']."','1','$mid','$name','$alipay','$time','$ddh')";
$dsql->ExecuteNoneQuery($sql);
//清空他的收益
$sql = "update #@__member set `shouyi` = '0.00' where mid = '$mid'";
$dsql->ExecuteNoneQuery($sql);
	showMsg('提交成功，请等待审核处理！','/member/');
	exit();	
		
	}
}


require_once(DEDEINC."/datalistcp.class.php");

//首页需要的一些参数

$arr = $dsql->GetOne("select sum(`jine`) as he from #@__jj_tixian where mid = '$mid' and zt = '1' ");
if(empty($arr['he'])){$arr['he'] = '0.00';}
$M['daidaozhang'] = round($arr['he'],2);

$arr = $dsql->GetOne("select sum(`jine`) as he from #@__jj_tixian where mid = '$mid' and zt = '2' ");
if(empty($arr['he'])){$arr['he'] = '0.00';}
$M['yilingqu'] = round($arr['he'],2); 

$arr = $dsql->GetOne("select count(mid) as dd from #@__member where tjrmid = '$mid'");
$M['dangqiantuiguang'] = $arr['dd'];


//"select count(mid) as dd from #@__member where tjrmid = '$mid' and yigoumai = '1' "
$query = "select count(a.id) as dd from  #@__jj_shouyi a left join #@__member m on a.mid = m.mid where a.tjrmid = '$mid' ";
$arr = $dsql->GetOne($query);
$M['yigoumai'] = $arr['dd'];
	
	
	
$dlist = new DataListCP();
$query = "";

if($a == 'shouyi'){
	$query = "select a.*,m.uname,t.ico from  #@__jj_shouyi a left join #@__member m on a.mid = m.mid  left join #@__arctype t on a.tid = t.id  where a.tjrmid = '$mid'   order by a.id desc"; //  
}else if($a == 'txjl'){
	$query = "select *  from  #@__jj_tixian   where  mid = '$mid' order by id desc";
}

 

$php_Self = str_replace('php','htm',substr($_SERVER['PHP_SELF'],strripos($_SERVER['PHP_SELF'],"/")+1)) ;
if(!empty($a)){
	$php_Self = str_replace('.htm','_'.$a.'.htm',$php_Self);
}

$dlist->SetTemplate("./templets/".$php_Self);
$dlist->SetParameter("a",$a); //自定义分页GET参数 
$dlist->pageSize = 6;
$dlist->SetSource($query);
$dlist->Display();
?>