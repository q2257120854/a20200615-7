<?php
/**
 * 寻梦资源网 http://www.xunmzy.com
 * 点赞插件
 * 数据传输
 */
require_once (dirname(dirname(__FILE__)) . "/include/common.inc.php");
$ip =getip(); //获取用户IP 
$id = $_POST['id'];
if(!isset($id) || empty($id)) exit; 
//查询已赞过的IP
$sql = "SELECT ip FROM `#@__zan`  WHERE aid='".$id."' and ip='$ip'";

$dsql->SetQuery($sql);
$dsql->Execute();
$count = $dsql->GetTotalRow();

if($a == 'zanlemei'){
	
	echo $count;
	exit();
}
 
if($count==0){ //如果没有记录 
 
    $dsql->ExecuteNoneQuery("update `#@__archives` set zan=zan+1 where id={$id}");//写入赞数
    
    $dsql->ExecuteNoneQuery("insert into `#@__zan` (aid,ip) values ('$id','$ip'); ");//写入IP,及被赞的AID 
 
    $rows = $dsql->GetOne("Select zan from `#@__archives` where id=".$id);//获取被赞的数量
    $zan = $rows['zan']; //获取赞数值 
    echo ' '.$zan.'';
}else{ 
    echo 0; 
}