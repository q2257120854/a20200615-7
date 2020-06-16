<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('member_List');
require_once(DEDEINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
$dopost = empty($dopost) ? "list" : $dopost;

if($dopost == 'list')
{
	$wheresql = '';
	if(!empty($keyword))
	{
		$memberRow = $dsql->GetOne("SELECT * FROM #@__member WHERE userid = '{$keyword}'");
		if(!empty($memberRow['mid']))
		{
			$wheresql = "WHERE mid = {$memberRow['mid']}";
		}
	}
	
	$sql = "SELECT * FROM #@__member_login {$wheresql} order by id DESC";
	$dlist = new DataListCP();

	$dlist->SetParameter('keyword',$keyword);
	$dlist->SetTemplet(DEDEADMIN."/templets/member_login.htm");
	$dlist->SetSource($sql);
	$dlist->display();
}else if($dopost == 'bind'){
	$sql = "UPDATE #@__member_login SET mid=0 where id = {$id}";
	if($dsql->ExecuteNoneQuery($sql))
	{
		ShowMsg("解除绑定成功","member_login.php");
		exit;
	}else{
		ShowMsg("解除绑定失败",-1);
		exit;
	}
}




?>