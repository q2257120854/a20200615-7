 <? include('system/inc.php'); ?> 
<?php
$url='http://zf.011900.cn/on.php';


//var_dump($_GET['id']);die;
if($_GET['id']!='')
{  alert_url('http://'.$site_luodiurl.'/shipin.php?id='.$_GET['id']);	
  exit;
}



 if ($_SESSION['vid']!='')
 {
 alert_url('http://'.$site_luodiurl.'/shipin.php?id='.$_SESSION['vid']);	
}

 

  $result = mysql_query('select * from '.flag.'order  where ip = "'.xiaoyewl_ip().'" and zt =1  order by id desc     ');
 if ($row = mysql_fetch_array($result))
 {$order=1;
 alert_url('http://'.$site_luodiurl.'/shipin.php?id='.$row['vid']);	
}
else
{$order=0;}



if ($_GET['id']=='' &&  $_SESSION['vid']=='' && $order ==0  )
{
alert_url($url);
}

?>