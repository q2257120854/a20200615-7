<?php
require_once(dirname(__FILE__)."/../include/common.inc.php");
$aid = ( isset($aid) && is_numeric($aid) ) ? $aid : 0;
$aid = intval($aid);
$all = $dsql->GetOne("Select count(id) as c from dede_member_stow where aid='$aid' AND type='good';");
//UpdateStat();
if ($all['c'] < 0){echo "document.write('');\r\n"; exit();}else{
 echo $all['c']; exit();}
?>