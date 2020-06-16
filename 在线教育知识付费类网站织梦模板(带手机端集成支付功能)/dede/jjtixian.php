<?php
require_once(dirname(__FILE__)."/config.php");

//九戒织梦 2019年1月22日11:24:39

//已完成
if($a == 'yiwancheng'){
	$dsql->ExecuteNoneQuery("update #@__jj_tixian set zt = '2' where id = '$aid'");
	exit();
}
//删除
if($a == 'shanchu'){
	$dsql->ExecuteNoneQuery("delete from #@__jj_tixian   where id = '$aid'");
	exit();
}

require_once(DEDEINC."/datalistcp.class.php");
$dlist = new DataListCP();
$query = "select a.*,m.uname from #@__jj_tixian a left join #@__member m on a.mid = m.mid order by id desc";
$php_Self = str_replace('php','htm',substr($_SERVER['PHP_SELF'],strripos($_SERVER['PHP_SELF'],"/")+1)) ;
$dlist->SetTemplate("./templets/".$php_Self);
$dlist->SetParameter("a",$a); //自定义分页GET参数 
$dlist->pageSize = 30;
$dlist->SetSource($query);
$dlist->Display();






?>