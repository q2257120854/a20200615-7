 <? include('../system/inc.php'); ?> 
<?php
if(isset($_GET['token']))
{
  $id = $_GET['token'] / 789;
  $trade_no = $_REQUEST["trade_no"];
	 alert_url('http://'.$_SERVER['HTTP_HOST'].'/shipin.php?id='.$id.'&d='.$trade_no);	
  die;
}


 if ($_SESSION['vid']!='')
 {
 alert_url('http://'.$_SERVER['HTTP_HOST'].'/shipin.php?id='.$_SESSION['vid']);	
}

else
{

  $result = mysql_query('select * from '.flag.'order  where ip = "'.xiaoyewl_ip().'" and zt =1  order by id desc     ');
$row = mysql_fetch_array($result);
 
{
 alert_url('http://'.$_SERVER['HTTP_HOST'].'/shipin.php?id='.$row['vid']);	
}
}?>